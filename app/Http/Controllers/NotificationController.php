<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notifier;

    public function __construct(NotificationService $notifier)
    {
        $this->notifier = $notifier;
    }

    // Admin form to create a notification
      public function create()
    {
        $users = User::orderBy('first_name')->get();
        return view('notifications.create', compact('users'));
    }

    // Store the notification
    public function store(Request $request)
    {
          $data= $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'target_type' => 'required|in:system,user',
            'user_id' => 'nullable|required_if:target_type,user|exists:users,id',
            'channel' => 'required|in:in_app,email,both',
        ]);

        $this->notifier->sendNotification(
            $data['title'],
            $data['message'],
            $data['target_type'],
            $data['channel'],
            $data['user_id']
        );

        return redirect()->route('notifications.index')->with('success', 'Notification sent successfully.');
    }
    public function myNotifications()
{
    $user = Auth::user();

    // system notifications + user-specific notifications
    $notifications = Notification::where(function ($q) use ($user) {
        $q->where('target_type', 'system')
          ->orWhere(function ($q2) use ($user) {
              $q2->where('target_type', 'user')
                 ->where('user_id', $user->id);
          });
    })->orderBy('created_at', 'desc')->get();

    return view('notifications.my', compact('notifications'));
}


    // For authenticated users to view their notifications
public function index(Request $request)
{
    $query = Notification::with('user')->latest();

    // Apply filters
    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    if ($request->filled('target_type')) {
        $query->where('target_type', $request->target_type);
    }

    if ($request->filled('channel')) {
        $query->where('channel', $request->channel);
    }

    if ($request->filled('time')) {
        $time = match ($request->time) {
            '1_day' => now()->subDay(),
            '1_week' => now()->subWeek(),
            '1_month' => now()->subMonth(),
            default => null,
        };

        if ($time) {
            $query->where('created_at', '<=', $time);
        }
    }

    $notifications = $query->paginate(10);
    $users = \App\Models\User::all(); // For the user dropdown

    return view('notifications.index', compact('notifications', 'users'));
}

    //Show specific notification
    public function show(Notification $notification)
    {
        $notification->load('user');
        // if ($notification->user->id !== Auth::id()) {
        //     abort(403, 'Unauthorized action.');
        // }

        return view('notifications.show', compact('notification'));
    }
  

    // Mark notification as read
  
//     public function markAsRead(Notification $notification): RedirectResponse
//     {
//          if ($notification->user->id !== Auth::id() && $notification->target_type !== 'system') {
//             abort(403, 'Unauthorized action.');
//         }
//             $notification->update(['is_read' => true]);      
//    return back()->with('success', 'Notification marked as read');
//     }
   public function markAsRead($notification)
{
    $notification=Notification::where('id', $notification)->first();
    $user = Auth::user();

    if (! $notification->isReadBy($user)) {
        $notification->readers()->attach($user->id, ['read_at' => now()]);
    }

    return redirect()->back()->with('success', 'Notification marked as read.');
    
}
    public function markAllAsRead()
    {
        $user = Auth::user();

        $notifications = Notification::where(function ($q) use ($user) {
            $q->where('target_type', 'system')
            ->orWhere('user_id', $user->id);
        })->get();

        foreach ($notifications as $notification) {
            $notification->readers()->syncWithoutDetaching([
                $user->id => ['read_at' => now()]
            ]);
        }

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

      public function edit(Notification $notification)
    {
        $users = User::orderBy('first_name')->get();
        return view('notifications.edit', compact('notification', 'users'));
    }
     public function update(Request $request, Notification $notification)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'target_type' => 'required|in:system,user',
            'user_id' => 'nullable|required_if:target_type,user|exists:users,id',
            'channel' => 'required|in:in_app,email,both',
        ]);

        $notification->update($data);

        return redirect()->route('notifications.index')->with('success', 'Notification updated successfully.');
    }

    // Delete notification
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return redirect()->route('notifications.index')->with('success', 'Notification deleted successfully.');
    }
    public function bulkDelete(Request $request)
{
    $query = Notification::query();

    if ($request->filled('user_id')) {
        $query->where('user_id', $request->user_id);
    }

    if ($request->filled('target_type')) {
        $query->where('target_type', $request->target_type);
    }

    if ($request->filled('channel')) {
        $query->where('channel', $request->channel);
    }

    if ($request->filled('time')) {
        $time = match ($request->time) {
            '1_day' => now()->subDay(),
            '1_week' => now()->subWeek(),
            '1_month' => now()->subMonth(),
            default => null,
        };

        if ($time) {
            $query->where('created_at', '<=', $time);
        }
    }

    $deletedCount = $query->delete();

    return redirect()->route('notifications.index')->with('success', "$deletedCount notifications deleted.");
}

 
 public function updateUserNotificationPreferences(Request $request, User $user)
{
    // Ensure the authenticated user is updating their own preferences
    if (Auth::user()->id !== $user->id) {
        abort(403, 'Unauthorized access to this user\'s notification preferences.');
    }
    $preferences = $request->input('notification_preferences', []);

    // You may validate if needed
    $validated = [
        'email' => (bool) ($preferences['email'] ?? false),
        'in_app' => (bool) ($preferences['in_app'] ?? true),
        'system' => (bool) ($preferences['system'] ?? true),
    ];

    $user->notification_preferences = $validated;
    $user->save();

    return redirect()->back()->with('success', 'Notification preferences updated successfully.');
}

 public function updateUserNotificationSettings()
    {
        return view('settings.user.notifications', [
            'user' => Auth::user()
        ]);
    }


   
}