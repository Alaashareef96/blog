<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{

    public function index()
    {

        $data = Permission::all();
        return response()->view('cms.spatie.permissions.index', ['permissions' => $data]);
    }



    public function show(Permission $permission)
    {
        //
    }


    public function edit(Permission $permission)
    {
        return view('cms.spatie.permissions.edit', ['permission' => $permission]);
    }


    public function update(Request $request, Permission $permission)
    {

            //
            $validator = Validator($request->all(), [
                'name' => 'required|string|min:3|max:50',
                'guard' => 'required|string|in:admin,pro',
            ]);

            if (!$validator->fails()) {
                $permission->name = $request->input('name');
                $permission->guard_name = $request->input('guard');
                $isSaved = $permission->save();
                return response()->json([
                    'message' => $isSaved ? 'Created successfully' : 'Create failed'
                ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
            } else {
                return response()->json([
                    'message' => $validator->getMessageBag()->first()
                ], Response::HTTP_BAD_REQUEST);
            }

    }

    public function destroy(Permission $permission)
    {

            //
            $isDeleted = $permission->delete();
            return response()->json([
                'icon'=>$isDeleted ? 'success':'error',
                'title'=>$isDeleted ? 'Deleted successfully':'Delete failed'
            ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);

    }
}
