<?php

namespace App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Controllers;


use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
use App\Http\Controllers\Controller;

use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\PermissionRoutes;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\RolePermission;
use App\Modules\ECOMMERCE\Managements\UserManagements\Users\Database\Models\User;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRole;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Database\Models\UserRolePermission;
use App\Modules\ECOMMERCE\Managements\UserManagements\Roles\Controllers\PermissionRoutesController;

class UserRoleController extends Controller
{
    public function __construct()
    {
        $this->loadModuleViewPath('ECOMMERCE/Managements/UserManagements/Roles');
    }
    public function viewAllUserRoles(Request $request)
    {
        if ($request->ajax()) {

            $data = UserRole::orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->editColumn('updated_at', function ($data) {
                    if ($data->updated_at) {
                        return date("Y-m-d h:i:s a", strtotime($data->updated_at));
                    }
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="' . url('edit/user/role') . '/' . $data->id . '" class="mb-1 btn-sm btn-warning rounded d-inline-block"><i class="fas fa-edit"></i></a>';
                    $btn .= ' <a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $data->id . '" data-original-title="Delete" class="btn-sm btn-danger rounded d-inline-block deleteBtn"><i class="fas fa-trash-alt"></i></a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('user_roles_view');
    }

    public function newUserRole()
    {
        // Get routes organized by Module > Groups > Routes structure
        $permissionController = new PermissionRoutesController();
        $moduleGroupRoutes = [];
        try {
            $moduleGroupRoutes = $permissionController->getRoutesByModuleAndGroup();
        } catch (\Throwable $e) {
            // If helper/controller fails, keep $moduleGroupRoutes empty and log the error
            \Log::error('Failed to get module group routes: ' . $e->getMessage());
        }

        // Check if 'home' route exists and mark it as checked
        $homeRoute = PermissionRoutes::where('route', 'home')->first();

        return view('user_role_create', compact('moduleGroupRoutes', 'homeRoute'));
    }

    public function saveUserRole(Request $request)
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:user_roles'],
        ]);

        $roleId = UserRole::insertGetId([
            'name' => $request->name,
            'description' => $request->description,
            'created_at' => Carbon::now()
        ]);

        foreach ($request->permission_id as $permissionId) {
            $routeInfo = PermissionRoutes::where('id', $permissionId)->first();
            RolePermission::insert([
                'role_id' => $roleId,
                'role_name' => $request->name,
                'permission_id' => $permissionId,
                'route' => $routeInfo->route,
                'route_name' => $routeInfo->name,
                'created_at' => Carbon::now()
            ]);
        }

        Toastr::success('New Role Created', 'Success');
        return redirect('view/user/roles');
    }

    public function deleteUserRole($id)
    {
        $userRoleInfo = UserRole::where('id', $id)->first();
        RolePermission::where('role_id', $userRoleInfo->id)->delete();
        UserRolePermission::where('role_id', $userRoleInfo->id)->delete();
        $userRoleInfo->delete();
        return response()->json(['success' => 'Made SuperAdmin Successfully']);
    }

    public function EditUserRole($id)
    {
        $moduleGroupRoutes = [];
        $permissionController = new PermissionRoutesController();
        try {
            $moduleGroupRoutes = $permissionController->getRoutesByModuleAndGroup();
        } catch (\Throwable $e) {
            // If helper/controller fails, keep $moduleGroupRoutes empty and log the error
            \Log::error('Failed to get module group routes: ' . $e->getMessage());
        }

        // Check if 'home' route exists and mark it as checked
        $homeRoute = PermissionRoutes::where('route', 'home')->first();
        $userRoleInfo = UserRole::where('id', $id)->first();

        // compute selected permissions for this role (safe if role not found)
        $selectedPermissions = [];
        if ($userRoleInfo) {
            try {
                $selectedPermissions = RolePermission::where('role_id', $userRoleInfo->id)
                    ->pluck('permission_id')
                    ->toArray();
            } catch (\Throwable $e) {
                \Log::error('Failed to fetch selected permissions for role ' . $id . ': ' . $e->getMessage());
            }
        }

        return view('user_role_edit', compact('userRoleInfo', 'moduleGroupRoutes', 'homeRoute', 'selectedPermissions'));
    }

    public function UpdateUserRole(Request $request)
    {

        // try {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        UserRole::where('id', $request->role_id)->update([
            'name' => $request->name,
            'description' => $request->description,
            'updated_at' => Carbon::now()
        ]);

        // Check if the permission is already assigned to the user
        $users = UserRolePermission::where('role_id', $request->role_id)
            ->select('user_id')
            ->distinct()
            ->get();

        // If any users are assigned to this role
        if ($users->count() > 0) {
            RolePermission::where('role_id', $request->role_id)->delete();
            UserRolePermission::where('role_id', $request->role_id)->delete();

            if (isset($request->permission_id) && count($request->permission_id) > 0) {
                foreach ($users as $user) {
                    foreach ($request->permission_id as $permissionId) {
                        $routeInfo = PermissionRoutes::where('id', $permissionId)->first();

                        RolePermission::insert([
                            'role_id' => $request->role_id,
                            'role_name' => $request->name,
                            'permission_id' => $permissionId,
                            'route' => $routeInfo->route,
                            'route_name' => $routeInfo->name,
                            'created_at' => Carbon::now()
                        ]);

                        UserRolePermission::insert([
                            'user_id' => $user->user_id,
                            'role_id' => $request->role_id,
                            'role_name' => $request->name,
                            'permission_id' => $permissionId,
                            'route' => $routeInfo->route,
                            'route_name' => $routeInfo->name,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()

                        ]);
                    }
                }
            }
        } else {
            RolePermission::where('role_id', $request->role_id)->delete();

            if (isset($request->permission_id) && count($request->permission_id) > 0) {

                foreach ($request->permission_id as $permissionId) {

                    $routeInfo = PermissionRoutes::where('id', $permissionId)->first();

                    RolePermission::insert([
                        'role_id' => $request->role_id,
                        'role_name' => $request->name,
                        'permission_id' => $permissionId,
                        'route' => $routeInfo->route,
                        'route_name' => $routeInfo->name,
                        'created_at' => Carbon::now()
                    ]);
                }
            }
        }

        Toastr::success('User Role Updated', 'Success');
        return redirect('view/user/roles');
        // } catch (\Exception $e) {
        //     \Log::error($e->getMessage());
        // }
    }

    public function viewUserRolePermission(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('user_type', 2)->orderBy('id', 'desc')->get();
            return Datatables::of($data)
                ->editColumn('created_at', function ($data) {
                    return date("Y-m-d h:i:s a", strtotime($data->created_at));
                })
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $btn = ' <a href="' . url('/assign/role/permission') . "/" . $data->id . '" class="btn-sm btn-warning rounded"><i class="fas fa-edit"></i> Assign</a>';
                    return $btn;
                })
                ->rawColumns(['action', 'user_type'])
                ->make(true);
        }
        return view('user_role_permission');
    }

    public function assignRolePermission($id)
    {
        $userId = $id;

        // Load roles and prepare display data for the view
        $userRoles = UserRole::orderBy('id', 'desc')->get();
        $rolesForView = [];
        foreach ($userRoles as $role) {
            $permissions = [];
            try {
                $permissions = RolePermission::where('role_id', $role->id)->pluck('route_name')->toArray();
            } catch (\Throwable $e) {
                \Log::error('Failed to fetch role permissions for role ' . $role->id . ': ' . $e->getMessage());
            }

            // Check whether this role is already assigned to the user
            $assigned = false;
            try {
                $assigned = UserRolePermission::where('user_id', $userId)->where('role_id', $role->id)->exists();
            } catch (\Throwable $e) {
                \Log::error('Failed to check user role assignment for user ' . $userId . ' role ' . $role->id . ': ' . $e->getMessage());
            }

            $rolesForView[] = (object) [
                'id' => $role->id,
                'name' => $role->name,
                'permissionsUnderRole' => implode(', ', $permissions),
                'assigned' => $assigned,
            ];
        }

        // Prepare permissions and module/group routes for permission assignment section
        $moduleGroupRoutes = [];
        try {
            $permissionController = new PermissionRoutesController();
            $moduleGroupRoutes = $permissionController->getRoutesByModuleAndGroup();
        } catch (\Throwable $e) {
            \Log::error('Failed to get module group routes: ' . $e->getMessage());
        }

        $userPermissions = [];
        try {
            $userPermissions = UserRolePermission::where('user_id', $userId)->pluck('permission_id')->toArray();
        } catch (\Throwable $e) {
            \Log::error('Failed to fetch user permissions for user ' . $userId . ': ' . $e->getMessage());
        }

        $homeRoute = PermissionRoutes::where('route', 'home')->first();

        return view('user_role_permission_assign', compact('userId', 'rolesForView', 'moduleGroupRoutes', 'userPermissions', 'homeRoute'));
    }

    public function SaveAssignedRolePermission(Request $request)
    {
        UserRolePermission::where('user_id', $request->user_id)->delete();

        if (isset($request->role_id) && count($request->role_id) > 0) {
            foreach ($request->role_id as $roleId) {
                $rolePermissions = RolePermission::where('role_id', $roleId)->get();
                foreach ($rolePermissions as $rolePermission) {
                    UserRolePermission::insert([
                        'user_id' => $request->user_id,
                        'role_id' => $rolePermission->role_id,
                        'role_name' => $rolePermission->role_name,
                        'permission_id' => $rolePermission->permission_id,
                        'route' => $rolePermission->route,
                        'route_name' => $rolePermission->route_name,
                        'created_at' => Carbon::now()
                    ]);
                }
            }
        }

        if (isset($request->permission_id) && count($request->permission_id) > 0) {
            foreach ($request->permission_id as $permissionId) {
                $routeInfo = PermissionRoutes::where('id', $permissionId)->first();

                // Check if the permission is already assigned to the user
                $existingPermission = UserRolePermission::where('user_id', request()->user_id)
                    ->where('permission_id', $permissionId)
                    ->first();

                if ($existingPermission) {
                    $existingPermission->update([
                        'updated_at' => Carbon::now()
                    ]);
                } else {
                    UserRolePermission::insert([
                        'user_id' => $request->user_id,
                        'role_id' => null,
                        'role_name' => null,
                        'permission_id' => $permissionId,
                        'route' => $routeInfo->route,
                        'route_name' => $routeInfo->name,
                        'created_at' => Carbon::now()
                    ]);
                }
            }
        }

        Toastr::success('User Role Updated', 'Success');
        return redirect('view/user/role/permission');
    }
}
