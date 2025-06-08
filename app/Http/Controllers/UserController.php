<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Http\Requests\UpdateUserProfileRequest;
use App\Models\Currency;

class UserController extends Controller
{
   
        // Logic to list users
    

public function index(Request $request)
{
    // Get the selected app_id from the request or default to 1
    $appId = $request->input('app_id', 1); // You can replace this with a helper if needed

    // Start user query with eager loading of roles limited to the selected app
    $query = User::query()->with(['roles' => function ($q) use ($appId) {
        $q->where('app_id', $appId);
    }]);

    // Apply search filter (matches first name, last name, or email)
    if ($search = $request->input('search')) {
        $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%");
        });
    }

    // Filter by user status if provided
    if ($status = $request->input('status')) {
        $query->where('status', $status);
    }

    // Filter users by selected role, scoped to the selected app
    if ($role = $request->input('role')) {
        $query->whereHas('roles', function ($q) use ($role, $appId) {
            $q->where('name', $role)
              ->where('app_id', $appId);
        });
    }

    // Paginate the filtered user results
    $users = $query->latest()->paginate(10)->withQueryString();

    // Load all roles along with their associated app
    $roles = Role::with('app')->get();

    // Group roles by app_id, using app name as the key for readability
    $rolesByApp = $roles->groupBy('app_id')->mapWithKeys(function ($group, $appId) {
        $appName = $group->first()->app->name ?? "App ID: $appId"; // Fallback if no app name
        return [$appName => $group];
    });

    // Load all apps for the app selector dropdown
    $availableApps = \App\Models\App::all();

    // Pass everything to the view
    return view('users.index', compact('users', 'rolesByApp', 'appId', 'availableApps'));
}

public function create()
{
    // Load roles with related app model
    $roles = Role::with('app')->get();

    // Group by app_id, then preserve app name using mapWithKeys
    $rolesByApp = $roles->groupBy('app_id')->mapWithKeys(function ($group, $appId) {
        $appName = $group->first()->app->name ?? "App ID: $appId";
        return [$appName => $group];
    });

    return view('users.create', compact('rolesByApp'));
}

public function profile()
{
    $user = Auth::user();

    // Get all roles grouped by app_id, e.g. [1 => ['Admin', 'Editor'], 2 => ['User']]
    $rolesByApp = $user->getAllAppRoles();

    // Get app details to map app_id => app name
    $apps = App::whereIn('id', $rolesByApp->keys())->pluck('name', 'id');
     $currencies = Currency::where('is_active', true)->orderBy('name')->get();

    // Build a structure: ['App Name' => ['Role1', 'Role2']]
    $rolesWithAppNames = $rolesByApp->mapWithKeys(function ($roles, $appId) use ($apps) {
        return [$apps[$appId] ?? 'Unknown App' => $roles];
    });

    return view('settings.user.profile', [
        'user' => $user,
        'rolesByApp' => $rolesWithAppNames,
        'currencies' => $currencies,
    ]);
}
 public function editUserForm(User $user)
    {
        return view('settings.user.edit_profile', compact('user'));
    }

   public function updateUserInfo(UpdateUserProfileRequest $request, $id)
{
    $user = User::findOrFail($id);


// dd($preferredCurrency);
    $data = $request->validated();


    // Handle avatar upload if present
    if ($request->hasFile('avatar')) {
        if ($user->avatar_url) {
            Storage::delete($user->avatar_url); // delete old avatar if exists
        }

        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $data['avatar_url'] = $avatarPath;
        unset($data['avatar']);

    }


    // Handle optional fields safely
    $optionalFields = [
        'phone', 'sex', 'date_of_birth', 'country', 'state', 'city', 'postal_code',
        'address', 'timezone', 'language', 'bio', 'website', 'profile_url','preferred_currency'
    ];

    foreach ($optionalFields as $field) {
        if (!isset($data[$field])) {
            $data[$field] = null; // ensure we clear fields if not sent
        }
    }

    $data['updated_by'] = Auth::id();

    $user->update($data);

    return redirect()->route('user.profile.show')->with('success', 'User updated successfully.');
}


    public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:users,email',
        'password'   => 'required|confirmed|min:8',
        'is_active'  => 'required|boolean',
        'roles'      => 'required|array',
        'roles.*'    => 'nullable|string',

        // Optional fields
        'phone'      => 'nullable|string|max:20',
        'gender'     => 'nullable|in:male,female,other',
        'position'   => 'nullable|string|max:255',
        'department' => 'nullable|string|max:255',
    ]);

    $user = User::create([
        'first_name' => $validated['first_name'],
        'last_name'  => $validated['last_name'],
        'email'      => $validated['email'],
        'password'   => bcrypt($validated['password']),
        'status'     => $validated['is_active'] ? 'active' : 'inactive',

        // Optional fields
        'phone'      => $validated['phone'] ?? null,
        'gender'     => $validated['gender'] ?? null,
        'position'   => $validated['position'] ?? null,
        'department' => $validated['department'] ?? null,
    ]);

    // Assign roles per app
    foreach ($validated['roles'] as $appId => $roleName) {
        if ($roleName) {
            $user->assignRoleWithApp($roleName, (int) $appId);
        }
    }

    return redirect()->route('users.index')->with('success', 'User created successfully.');
}


public function edit(User $user)
{
    $apps = App::all();

    $rolesByApp = Role::all()->groupBy('app_id');
    $permissionsByApp = Permission::all()->groupBy('app_id');

    return view('users.edit', compact('user', 'apps', 'rolesByApp', 'permissionsByApp'));
}

public function update(Request $request, User $user)
{
    // Update status
    $user->is_active = $request->has('is_active');
    $user->save();

    // Sync Roles per app
    foreach ($request->input('roles', []) as $appId => $roleName) {
        $user->removeAllRolesFromApp($appId);
        if ($roleName) {
            $user->assignRoleWithApp($roleName, $appId);
        }
    }

    // Sync Permissions
    $allPermissions = Permission::all();
    foreach ($allPermissions->groupBy('app_id') as $appId => $appPermissions) {
        // Revoke all
        foreach ($appPermissions as $permission) {
            $user->revokeAppPermissionTo($permission->name, $appId);
        }

        // Grant selected
        foreach ($request->input("permissions.$appId", []) as $permissionName) {
            $user->giveAppPermissionTo($permissionName, $appId);
        }
    }

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}

public function toggleRole(User $user, int $appId, string $roleName)
{
    // dd('here');
    if ($user->hasRoleWithApp($roleName, $appId)) {
        $user->revokeRoleFromApp($roleName, $appId);
    } else {
        $user->assignRoleWithApp($roleName, $appId);
    }

    return back()->with('success', 'Role updated Successfully.');
}

public function updateStatus(Request $request, User $user)
{
    $validated = $request->validate([
        'status' => ['required', Rule::in(['active', 'inactive', 'pending', 'suspended', 'banned'])],
    ]);

    $user->update(['status' => $validated['status']]);

    return back()->with('success', 'User status updated successfully.');
}

public function show(User $user)
{
    $user->load('roles'); // eager load roles (and optionally other relations)

    // Group roles by app if needed
    $rolesByApp = $user->roles->groupBy(function ($role) {
        return $role->app->name ?? 'Unknown App';
    });

    return view('users.show', compact('user', 'rolesByApp'));
}
public function destroy(User $user)
{
    // Detach all roles and permissions
    $user->roles()->detach();
    $user->permissions()->detach();
//     try{    DB::table('roles')->where('id', $role->id)->delete();
// } catch(\Exception $e){
//     return redirect()->route('roles.index')->with('error', 'Role cannot be deleted as it is in use.');
// }

    // Delete the user
    $user->delete();

    return redirect()->route('users.index')->with('success', 'User deleted successfully.');
}

}
