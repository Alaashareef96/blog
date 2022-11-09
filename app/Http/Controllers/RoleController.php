<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{

    public function index()
    {
        if (Gate::denies('Read-Roles')) {
            abort(403);
        }
        $data = Role::withCount('permissions')->get();
        return response()->view('cms.spatie.roles.index', ['roles' => $data]);
    }


    public function create()
    {
        if (Gate::denies('Create-Role')) {
            abort(403);
        }
        return response()->view('cms.spatie.roles.create');
    }


    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'guard' => 'required|string|in:admin,web',
        ]);

        if (!$validator->fails()) {
            $role = new Role();
            $role->name = $request->input('name');
            $role->guard_name = $request->input('guard');
            $isSaved = $role->save();
            return response()->json([
                'message' => $isSaved ? 'Created successfully' : 'Create failed'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function show(Role $role)
    {
        //
        $permissions = Permission::where('guard_name', $role->guard_name)->get();
        $rolePermissions = $role->permissions;
        foreach ($permissions as $permission) {
            $permission->setAttribute('assigned', false);
            foreach ($rolePermissions as $rolePermission) {
                if ($rolePermission->id == $permission->id) {
                    $permission->SetAttribute('assigned', true);
                }
            }
        }
        return view('cms.spatie.roles.role-permissions', ['role' => $role, 'permissions' => $permissions]);
    }


    public function edit(Role $role)
    {
        if (Gate::denies('Update-Role')) {
            abort(403);
        }
        return view('cms.spatie.roles.edit', ['role' => $role]);
    }


    public function update(Request $request, Role $role)
    {
        //
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:50',
            'guard' => 'required|string|in:admin,web',
        ]);

        if (!$validator->fails()) {
            $role->name = $request->input('name');
            $role->guard_name = $request->input('guard');
            $isSaved = $role->save();
            return response()->json([
                'message' => $isSaved ? 'Created successfully' : 'Create failed'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }


    public function destroy(Role $role)
    {
        if (Gate::denies('Delete-Role')) {
            abort(403);
        }
        $isDeleted = $role->delete();
        return response()->json([
            'icon'=>$isDeleted ? 'success':'error',
            'title'=>$isDeleted ? 'Deleted successfully':'Delete failed'
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
