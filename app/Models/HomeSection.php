<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use App\Traits\LogsActivity;

class HomeSection extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;
    
    protected $logTitleField = 'title_english';

    protected $table = 'home_sections';
    protected $guarded = [];

    /**
     * Get all active home sections ordered by ordering field
     */
    public static function getActiveSections()
    {
        return self::where('status', 0)
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->get();
    }

    /**
     * Get all home sections for admin listing
     */
    public static function list()
    {
        return DB::table('home_sections')
            ->select('id', 'name', 'title_english', 'title_arabic', 'blade_view', 'icon', 'ordering', 'status', 'show_divider', 'description', 'created_at', 'updated_at')
            ->whereNull('deleted_at')
            ->orderBy('ordering', 'asc')
            ->get();
    }

    /**
     * Get trashed home sections
     */
    public static function trashed()
    {
        return DB::table('home_sections')
            ->select('id', 'name', 'title_english', 'title_arabic', 'deleted_at')
            ->whereNotNull('deleted_at')
            ->orderBy('deleted_at', 'desc')
            ->get();
    }

    /**
     * Update ordering for multiple sections
     */
    public static function updateOrdering(array $orderings)
    {
        foreach ($orderings as $id => $order) {
            self::where('id', $id)->update(['ordering' => $order]);
        }
    }

    /**
     * Toggle section status
     */
    public function toggleStatus()
    {
        $this->status = $this->status == 0 ? 1 : 0;
        $this->save();
        return $this;
    }

    /**
     * Toggle show divider
     */
    public function toggleDivider()
    {
        $this->show_divider = $this->show_divider == 0 ? 1 : 0;
        $this->save();
        return $this;
    }
}
