<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function index()
    {
        if (Gate::denies('Read-Admins')) {
            abort(403);
        }
        $data = Admin::all();
        return response()->view('cms.admins.index', compact('data'));
    }


    public function create()
    {
        if (Gate::denies('Create-Admin')) {
            abort(403);
        }
        $roles = Role::where('guard_name', '=', 'admin')->get();
        return response()->view('cms.admins.create', compact('roles'));
    }


    public function store(AdminRequest $request)
    {

            $role = Role::findById($request->input('role_id'), 'admin');
            $admin = new Admin();
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->password = Hash::make(12345);
            $isSaved = $admin->save();
            if ($isSaved)
                $admin->assignRole($role);
                 event(new Registered($admin));
            return response()->json([
                'message' => $isSaved ? 'Created successfully' : 'Create failed'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }


    public function edit(Admin $admin)
    {
        if (Gate::denies('Update-Admin')) {
            abort(403);
        }
        $roles = Role::where('guard_name', '=', 'admin')->get();
        $adminRole = $admin->roles()->first();
        return response()->view('cms.admins.edit', ['admin' => $admin, 'roles' => $roles, 'adminRole' => $adminRole]);
    }

    public function update(AdminRequest $request, Admin $admin)
    {

            $role = Role::findById($request->input('role_id'), 'admin');
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $isSaved = $admin->save();
            if ($isSaved) $admin->syncRoles($role);
            return response()->json([
                'message' => $isSaved ? 'Updated successfully' : 'Update failed'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);

    }


    public function destroy(Admin $admin)
    {
        if (Gate::denies('Delete-Admin')) {
            abort(403);
        }
        $deleted = $admin->delete();
        return response()->json([
            'title' => $deleted ? 'Deleted successfully' : "Delete failed",
            'icon' => $deleted ? 'success' : "error",
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
