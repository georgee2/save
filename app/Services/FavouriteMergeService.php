<?php

namespace App\Services;

use App\Models\Favourite;
use App\Models\FavouriteComment;
use App\Models\FavouriteEmailLog;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

/**
 * Merges a guest's cookie-based favourites into a customer account at login,
 * consolidating everything under the customer's canonical `favourites_token`.
 *
 * Idempotent and safe on MyISAM (favourites tables have no transactions/FKs):
 * the guest cookie is forgotten only after the work completes, and every write
 * is an upsert-style stamp, so a re-fired Login simply completes any partial run.
 */
class FavouriteMergeService
{
    public function mergeGuestIntoAccount(User $user, ?string $guestId): void
    {
        if (!$user->isCustomer()) {
            return;
        }

        $guestId = $guestId ? trim($guestId) : null;
        $canonical = $user->favourites_token;

        // Contact + ownership stamp applied to the customer's favourite rows.
        $contact = [
            'user_id'      => $user->id,
            'is_permanent' => true,
            'name'         => $user->name,
            'email'        => $user->email,
            'mobile'       => $user->phone,
        ];

        // Case A: the guest cookie already IS the canonical list (logged-in
        // toggle, or a re-fired login) -> just (re)stamp and finish.
        if ($guestId && $canonical && $guestId === $canonical) {
            Favourite::forSession($canonical)->update($contact);
            $this->forgetGuestCookie();
            return;
        }

        // Only unclaimed guest rows (user_id IS NULL) are eligible to merge.
        $guestHasRows = $guestId && Favourite::forSession($guestId)->whereNull('user_id')->exists();

        // Case B: nothing to merge from this browser.
        if (!$guestHasRows) {
            if ($canonical) {
                Favourite::forSession($canonical)->update($contact); // keep canonical stamped
            }
            $this->forgetGuestCookie();
            return;
        }

        // Case C: customer has no list yet -> adopt the guest id as canonical.
        if (empty($canonical)) {
            $user->forceFill(['favourites_token' => $guestId])->save();
            Favourite::forSession($guestId)->update($contact);
            $this->forgetGuestCookie();
            return;
        }

        // Case D: both exist and differ -> merge guest list into the canonical one.
        DB::transaction(function () use ($guestId, $canonical, $contact) {
            // 1) Dedupe against UNIQUE(session_id,item_type,item_id): delete guest
            //    rows whose item already exists under the canonical list.
            $existingSet = Favourite::forSession($canonical)
                ->get(['item_type', 'item_id'])
                ->mapWithKeys(fn ($r) => [$r->item_type . ':' . $r->item_id => true])
                ->all();

            foreach (Favourite::forSession($guestId)->get(['id', 'item_type', 'item_id']) as $g) {
                if (isset($existingSet[$g->item_type . ':' . $g->item_id])) {
                    Favourite::whereKey($g->id)->delete();
                }
            }

            // 2) Carry the guest list's assigned agent onto canonical rows that
            //    have none (don't overwrite an existing canonical assignment).
            $guestAgentId = Favourite::forSession($guestId)->whereNotNull('sales_agent_id')->value('sales_agent_id');
            if ($guestAgentId) {
                Favourite::forSession($canonical)->whereNull('sales_agent_id')->update(['sales_agent_id' => $guestAgentId]);
            }

            // 3) Move surviving guest rows onto the canonical list.
            Favourite::forSession($guestId)->update(array_merge(['session_id' => $canonical], $contact));

            // 4) Re-key the CRM side tables (session_id only — their user_id is the staff author/sender).
            FavouriteComment::where('session_id', $guestId)->update(['session_id' => $canonical]);
            FavouriteEmailLog::where('session_id', $guestId)->update(['session_id' => $canonical]);

            // 5) Re-stamp the whole canonical list.
            Favourite::forSession($canonical)->update($contact);
        });

        $this->forgetGuestCookie();
    }

    protected function forgetGuestCookie(): void
    {
        Cookie::queue(Cookie::forget('favourite_session_id'));
    }
}
