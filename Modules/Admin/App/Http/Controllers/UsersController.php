<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Image;

use App\Models\User;

class UsersController extends Controller
{
    protected $User;

    public function __construct(User $User)
    {
        $this->User = $User;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('admin::users.index', [
            'data' => $this->User->list(),
            'urls' => array(
                'add' => URL::to('admin/users/create'),
                'update' => URL::to('admin/users/edit'),
                'delete' => URL::to('/admin/users/delete')
            ),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('admin::users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $this->User->NewRecord([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'account_type' => 'staff',
            'source' => 'admin',
            'password_set_at' => now(),
        ]);

        return redirect()->route('users.index')->with('success',  __('lang.session.add'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('admin::users.edit',[
            'User' => $this->User->find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $data['password_set_at'] = now();
        }

        $this->User->updateRecord($id, $data);

        return redirect()->route('users.index')->with('success', __('lang.session.update'));
    }


     /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $target = $this->User->find($id);

        // Prevent deleting your own account.
        if ((int) $id === (int) Auth::id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Only a super-admin may delete another super-admin.
        if ($target->isSuperAdmin() && !Auth::user()->isSuperAdmin()) {
            return redirect()->route('users.index')
                ->with('error', 'You do not have permission to delete a Super Admin account.');
        }

        $this->User->deleteRecord($id);

        return redirect()->route('users.index')->with('success', __('lang.session.delete'));
    }




}
