<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\Request;
use App\Models\App;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{

public function index(Request $request)
{
    $search = $request->input('search');
    $appId = $request->input('app_id');
    $guardName = $request->input('guard_name');

    // Retrieve all apps for the filter dropdown
    $availableApps = App::all();

    // Base query
    $query = Role::query();

    if ($search) {
        $query->where('name', 'LIKE', "%{$search}%");
    }

    if ($appId) {
        $query->where('app_id', $appId);
    }

    if ($guardName) {
        $query->where('guard_name', $guardName);
    }

    // Paginate results
    $roles = $query->orderBy('name')->paginate(10);

    // Distinct guard names for filter dropdown
    $guardNames = Role::select('guard_name')->distinct()->pluck('guard_name');

    return view('roles.index', [
        'roles' => $roles,
        'availableApps' => $availableApps,
        'appId' => $appId,
        'search' => $search,
        'guardName' => $guardName,
        'guardNames' => $guardNames,
    ]);
}

public function create()
{
    $apps = App::all(); // fetch apps for dropdown
    return view('roles.create', compact('apps'));
}
public function store(StoreRoleRequest $request)
{
    Role::create($request->validated());
    return redirect()->route('roles.index')->with('success', 'Role created successfully.');
}

public function update(UpdateRoleRequest $request, Role $role)
{
    $role->update($request->validated());
    return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
}

public function edit(Role $role)
{
    $apps = App::all(); // fetch apps for dropdown
    return view('roles.edit', compact('role', 'apps'));
}


public function destroy(Role $role)
{
try{    DB::table('roles')->where('id', $role->id)->delete();
} catch(\Exception $e){
    return redirect()->route('roles.index')->with('error', 'Role cannot be deleted as it is in use.');
}
   
    // Also clean up related pivot entries
  //  DB::table('model_has_roles')->where('role_id', $role->id)->delete();
   // DB::table('role_has_permissions')->where('role_id', $role->id)->delete();

    return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
}

public function show(Role $role)
{
return view('roles.show', [
    'role' => $role->load('permissions', 'app')
]);
}
}

