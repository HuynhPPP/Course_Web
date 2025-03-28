<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Exports\PermissionExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PermissionImport;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Row;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function AllPermission()
    {
        $permissions = Permission::all();

        return view('admin.backend.pages.permission.all_permission', compact('permissions'));
    }

    public function AddPermission()
    {
        $permissions = Permission::all();

        return view('admin.backend.pages.permission.add_permission', compact('permissions'));
    }

    public function StorePermission(Request $request)
    {
        Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Created Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.permission')->with($notification);
    }

    public function EditPermission($id)
    {
        $permission = Permission::find($id);

        return view('admin.backend.pages.permission.edit_permission', compact('permission'));
    }

    public function UpdatePermission(Request $request)
    {
        $permission_id = $request->id;

        Permission::find($permission_id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        $notification = array(
            'message' => 'Permission Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.permission')->with($notification);
    }

    public function DeletePermission($id)
    {
        Permission::find($id)->delete();

        $notification = array(
            'message' => 'Permission Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    public function ImportPermission()
    {
        return view('admin.backend.pages.permission.importy_permission');
    }

    public function Export()
    {
        return Excel::download(new PermissionExport, 'permission.xlsx');
    }

    public function Import(Request $request)
    {
        Excel::import(new PermissionImport, $request->file('import_file'));

        $notification = array(
            'message' => 'Permission Imported Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.permission')->with($notification);
    }

    public function AllRoles()
    {
        $roles = Role::all();

        return view('admin.backend.pages.roles.all_roles', compact('roles'));
    }

    public function AddRoles()
    {
        $roles = Role::all();

        return view('admin.backend.pages.roles.add_roles', compact('roles'));
    }

    public function StoreRoles(Request $request)
    {
        Role::create([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Role Created Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.roles')->with($notification);
    }

    public function EditRoles($id)
    {
        $roles = Role::find($id);

        return view('admin.backend.pages.roles.edit_roles', compact('roles'));
    }
    public function UpdateRoles(Request $request)
    {
        $role_id = $request->id;

        Role::find($role_id)->update([
            'name' => $request->name,
        ]);

        $notification = array(
            'message' => 'Role Updated Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.roles')->with($notification);
    }

    public function DeleteRoles($id)
    {
        Role::find($id)->delete();

        $notification = array(
            'message' => 'Roles Deleted Successfully',
            'alert-type' => 'success',
        );
        return redirect()->back()->with($notification);
    }

    /////// Add Role Permission All Method ///////
    public function AddRolesPermission()
    {
        $roles = Role::all();
        $permission_group = User::getPermissionGroup();
        $permissions = Permission::all();

        return view(
            'admin.backend.pages.rolesetup.add_roles_permission',
            compact('roles', 'permission_group', 'permissions')
        );
    }

    public function RolePermissionStore(Request $request)
    {
        $data = array();
        $permissions = $request->permission;

        foreach ($permissions as $key => $item) {
            $data['role_id'] = $request->role_id;
            $data['permission_id'] = $item;

            DB::table('role_has_permissions')->insert($data);
        }

        $notification = array(
            'message' => 'Role Permission Added Successfully',
            'alert-type' => 'success',
        );
        return redirect()->route('all.roles.permission')->with($notification);
    }

    public function AllRolesPermission()
    {
        $roles = Role::all();

        return view('admin.backend.pages.rolesetup.all_roles_permission', compact('roles'));
    }

    public function AdminEditRoles($id)
    {
        $role = Role::find($id);
        $permission_groups = User::getPermissionGroup();
        $permissions = Permission::all();

        return view(
            'admin.backend.pages.rolesetup.edit_roles_permission',
            compact('role', 'permission_groups', 'permissions')
        );
    }

    public function AdminUpdateRoles(Request $request, $id)
    {
        $role = Role::find($id);
        $permissionIds = $request->permission; // Nhận danh sách ID từ form

        if (!empty($permissionIds)) {
            // Lấy danh sách ID permissions thay vì tên
            $role->permissions()->sync($permissionIds); // Chỉ cần dùng ID
        } 

        $notification = [
            'message' => 'Role Permission Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('all.roles.permission')->with($notification);
    }

    public function AdminDeleteRoles($id)
    {
        $role = Role::find($id);
        if (!is_null($role)) {
            $role->delete();
        }

        $notification = [
            'message' => 'Role Permission Deleted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('all.roles.permission')->with($notification);
    }
}
