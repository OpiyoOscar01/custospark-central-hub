<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\BlogReactionController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\FeedbackController;
use App\Http\Controllers\Client\InvoiceController;
use App\Http\Controllers\Client\ProjectController as ClientProjectController;
use App\Http\Controllers\CompanyJobController;
use App\Http\Controllers\DocumentController;use App\Http\Controllers\EmployeeController;use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MilestoneController;
use App\Http\Controllers\NotificationController;use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PlanFeatureController;
use App\Http\Controllers\SubtaskController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\TimeLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard/original', function () {
    return redirect(route('portal.blog'));
})->middleware(['auth', 'verified'])->name('dashboardOriginal');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::view('/about-us', 'pages.about_us')->name('about-us');
Route::view('/contact-us', 'pages.contact_us')->name('contact-us');
Route::view('/services', 'pages.services')->name('services');
Route::view('consultation', 'pages.consultation')->name('consultation');
Route::view('post-consultation', 'pages.post-consultation')->name('post-consultation');
Route::view('jobs-offers', 'pages.careers')->name('home.careers');
Route::view('application', 'pages.application_form')->name('application_form');
Route::view('application-success', 'pages.post_application')->name('application_success');
Route::view('investor-relations', 'pages.investor_relations')->name('investor_relations');
Route::view('products', 'pages.products')->name('products.custosell');
Route::view('pricing/custosell','pages.pricing_custosell')->name('pricing.custosell');
Route::view('pricing/custohost','pages.pricing_custohost')->name('pricing.custohost');
Route::view('pricing/custospace','pages.pricing_custospace')->name('pricing.custospace');


/** Login Redirect */
Route::get('/login/custospark', function () {
    $redirectUrl = request()->fullUrl();

    if (app()->environment('production')) {
        $target = 'https://custospark.com/login?redirect=' . urlencode($redirectUrl);
    } else {
        $target = 'http://custospark.test:8000/login?redirect=' . urlencode($redirectUrl);
    }

    return redirect()->away($target);
})->name('login.redirect');



Route::get('/sso/logout', [LogoutController::class, 'globalLogout'])->name('sso.logout');

/**Login Redirect */
Route::get('/login/custospark', function () {

    return redirect()->away('http://custospark.test:8000/login?redirect=' . urlencode(request()->fullUrl()));
})->name('login.redirect');

Route::get('/login/redirect',[AuthenticatedSessionController::class,'loginWithToken'])->name('login.with.token');



/**
 * Blog Routes
 */
Route::middleware(['sso.auth','check.app.roles:super-admin,admin'])->group(
    function(){
        Route::get('/portal/blogs', [BlogController::class, 'index'])->name('portal.blog');
        Route::get('/portal/blogs/create', [BlogController::class, 'create'])->name('portal.blog.create');
        Route::post('/portal/blogs/store', [BlogController::class, 'store'])->name('portal.blog.store');
        Route::get('/portal/blogs/{id}', [BlogController::class, 'show'])->name('portal.blog.show');
        Route::get('/portal/blogs/{id}/edit', [BlogController::class, 'edit'])->name('portal.blog.edit');
        Route::put('/portal/blogs/{id}', [BlogController::class, 'update'])->name('portal.blog.update');
        Route::delete('/portal/blogs/{id}', [BlogController::class, 'destroy'])->name('portal.blog.destroy');
        
    }
);

/**
 * Carrers
 *
 */

Route::prefix('careers')->group(function () {
    Route::get('/', [CareerController::class, 'index'])->name('Portal.content.careers');
    Route::post('/', [CareerController::class, 'store'])->name('careers.store');
    Route::get('/{id}', [CareerController::class, 'show'])->name('careers.show');
    Route::put('/{id}', [CareerController::class, 'update'])->name('careers.update');
    Route::delete('/{id}', [CareerController::class, 'destroy'])->name('careers.destroy');
});

//Advanced Calendar Routes

Route::prefix('calendar')->name('calendar.')->group(function () {
    Route::get('/', [CalendarController::class, 'index'])->name('index');
    Route::get('/day', [CalendarController::class, 'index'])->name('day');
    Route::get('/week', [CalendarController::class, 'index'])->name('week');
    Route::get('/month', [CalendarController::class, 'index'])->name('month');
    Route::get('/year', [CalendarController::class, 'index'])->name('year');
});

Route::middleware(['sso.auth'])->group(function () {
    // Dashboard Routes
    // Route::get('/', function () {
    //     return redirect()->route('dashboard');
    // });

    //Admin Routes
    // Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::get('/roles', [AdminController::class, 'roles'])->name('roles');
        Route::get('/permissions', [AdminController::class, 'permissions'])->name('permissions');
    });

    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
    // ->middleware('check.app.roles:normal-user,super-admin');
})->name('dashboard');

// Employee Routes
Route::prefix('staff')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
    Route::get('/tasks', [EmployeeController::class, 'tasks'])->name('tasks');
    Route::get('/projects', [EmployeeController::class, 'projects'])->name('projects');
    Route::get('/time-logs', [EmployeeController::class, 'timeLogs'])->name('time-logs');
});

// // Calendar Routes
// Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.day');
// Route::get('/calendar/day', [CalendarController::class, 'day'])->name('calendar.day');
// Route::get('/calendar/week', [CalendarController::class, 'week'])->name('calendar.week');
// Route::get('/calendar/month', [CalendarController::class, 'month'])->name('calendar.index');
Route::get('/calendar/task/{task}/export', [CalendarController::class, 'exportIcs'])->name('calendar.export-task');

// Notification Routes
// Route::post('notifications/{notification}/mark-as-read', [NotificationController::class, 'markAsRead'])
//     ->name('notifications.mark-as-read');
// Route::post('notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])
//     ->name('notifications.mark-all-as-read');

// Time Log Routes(Done)
Route::get('/time-logs', [TimeLogController::class, 'index'])->name('time-logs.index');
Route::get('/time-logs/create', [TimeLogController::class, 'create'])->name('time-logs.create');
Route::post('/time-logs', [TimeLogController::class, 'store'])->name('time-logs.store');
Route::get('/time-logs/{timeLog}', [TimeLogController::class, 'show'])->name('time-logs.show');
Route::get('/time-logs/{timeLog}/edit', [TimeLogController::class, 'edit'])->name('time-logs.edit');
Route::put('/time-logs/{timeLog}', [TimeLogController::class, 'update'])->name('time-logs.update');
Route::delete('/time-logs/{timeLog}', [TimeLogController::class, 'destroy'])->name('time-logs.destroy');

// Resource Routes
Route::get('/resources', [ResourceController::class, 'index'])->name('resources.index');
Route::get('/resources/create', [ResourceController::class, 'create'])->name('resources.create');
Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('resources.show');
Route::get('/resources/{resource}/edit', [ResourceController::class, 'edit'])->name('resources.edit');
Route::put('/resources/{resource}', [ResourceController::class, 'update'])->name('resources.update');
Route::delete('/resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');

// Client Routes
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
Route::put('/clients/{client}', [ClientController::class, 'update'])->name('clients.update');
Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');

// Project Routes
Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
Route::put('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');

// Document Routes
Route::get('/documents/{project}', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/create/{project}', [DocumentController::class, 'create'])->name('documents.create');
Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
Route::get('/documents/download/{document}', [DocumentController::class, 'show'])->name('documents.download');
Route::get('/documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
Route::put('/documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');

// Milestone Routes
Route::get('/milestones', [MilestoneController::class, 'index'])->name('milestones.index');
Route::get('/milestones/create/{project}', [MilestoneController::class, 'create'])->name('milestones.create');
Route::post('/milestones', [MilestoneController::class, 'store'])->name('milestones.store');
Route::get('/milestones/{milestone}', [MilestoneController::class, 'show'])->name('milestones.show');
Route::get('/milestones/{milestone}/edit', [MilestoneController::class, 'edit'])->name('milestones.edit');
Route::put('/milestones/{milestone}', [MilestoneController::class, 'update'])->name('milestones.update');
Route::delete('/milestones/{milestone}', [MilestoneController::class, 'destroy'])->name('milestones.destroy');

// Message Routes(Done)
Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
Route::get('/messages/{message}/edit', [MessageController::class, 'edit'])->name('messages.edit');
Route::put('/messages/{message}', [MessageController::class, 'update'])->name('messages.update');
Route::delete('/messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

// Task Routes(Done)
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');

// Subtask Routes(Done)
Route::get('/subtasks', [SubtaskController::class, 'index'])->name('subtasks.index');
Route::get('/subtasks/create', [SubtaskController::class, 'create'])->name('subtasks.create');
Route::post('/subtasks', [SubtaskController::class, 'store'])->name('subtasks.store');
Route::get('/subtasks/{subtask}', [SubtaskController::class, 'show'])->name('subtasks.show');
Route::get('/subtasks/{subtask}/edit', [SubtaskController::class, 'edit'])->name('subtasks.edit');
Route::put('/subtasks/{subtask}', [SubtaskController::class, 'update'])->name('subtasks.update');
Route::delete('/subtasks/{subtask}', [SubtaskController::class, 'destroy'])->name('subtasks.destroy');

// Team Member Routes(Done)
Route::get('/team-members', [TeamMemberController::class, 'index'])->name('team-members.index');
Route::get('/team-members/create/{projectId}', [TeamMemberController::class, 'create'])->name('team-members.create');
Route::post('/team-members', [TeamMemberController::class, 'store'])->name('team-members.store');
Route::get('/team-members/{teamMember}', [TeamMemberController::class, 'show'])->name('team-members.show');
Route::get('/team-members/{teamMember}/edit', [TeamMemberController::class, 'edit'])->name('team-members.edit');
Route::put('/team-members/{teamMember}', [TeamMemberController::class, 'update'])->name('team-members.update');
Route::delete('/team-members/{teamMember}', [TeamMemberController::class, 'destroy'])->name('team-members.destroy');

// Time Tracking Routes(Done)
Route::post('time-logs/start/', [TimeLogController::class, 'startTimer'])->name('time-logs.start');
Route::post('time-logs/stop/', [TimeLogController::class, 'stopTimer'])->name('time-logs.stop');
Route::post('time-logs/{timeLog}/approve', [TimeLogController::class, 'approve'])->name('time-logs.approve');
Route::post('time-logs/{timeLog}/reject', [TimeLogController::class, 'reject'])->name('time-logs.reject');
Route::get('time-logs/export/{format}', [TimeLogController::class, 'export'])->name('time-logs.export');

// Report Routes
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('index');
    Route::get('/project-burndown/{project}', [ReportController::class, 'projectBurndown'])->name('project-burndown');
    Route::get('/resource-utilization', [ReportController::class, 'resourceUtilization'])->name('resource-utilization');
    Route::get('/cost-tracking/{project}', [ReportController::class, 'costTracking'])->name('cost-tracking');
    Route::get('/team-performance', [ReportController::class, 'teamPerformance'])->name('team-performance');
    Route::get('/project/{project}/export/{format}', [ReportController::class, 'exportProjectReport'])->name('export-project');
    Route::get('/time-logs/export/{format}', [ReportController::class, 'exportTimeLogReport'])->name('export-time-logs');
});

// Client Portal Routes
Route::middleware(['client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    Route::get('/projects', [ClientProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ClientProjectController::class, 'show'])->name('projects.show');
    Route::get('/projects/{project}/documents', [ClientProjectController::class, 'documents'])->name('projects.documents');
    Route::get('/projects/{project}/timeline', [ClientProjectController::class, 'timeline'])->name('projects.timeline');
    Route::resource('feedbacks', FeedbackController::class);
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::post('/invoices/{invoice}/approve', [InvoiceController::class, 'approve'])->name('invoices.approve');
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
});

// API Documentation Route
Route::view('/api-docs', 'api-docs')->name('api.docs');

//Blog Routes

Route::middleware(['sso.auth'])->group(function () {
    // Blog Management Routes
    Route::prefix('blog')->name('blog.')->group(function () {

        Route::middleware(['check.app.roles:super-admin,admin'])->group(function () {
        
        // Posts Management
        Route::get('/', [BlogPostController::class, 'index'])->name('index');
        Route::get('/create', [BlogPostController::class, 'create'])->name('create');
        Route::post('/', [BlogPostController::class, 'store'])->name('store');
        Route::get('/{post}/edit', [BlogPostController::class, 'edit'])->name('edit');
        Route::put('/{post}', [BlogPostController::class, 'update'])->name('update');
        Route::delete('/{post}', [BlogPostController::class, 'destroy'])->name('delete');

        // Category Management
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [BlogCategoryController::class, 'index'])->name('index');
            Route::post('/', [BlogCategoryController::class, 'store'])->name('store');
            Route::put('/{category}', [BlogCategoryController::class, 'update'])->name('update');
            Route::delete('/{category}', [BlogCategoryController::class, 'destroy'])->name('delete');
        });
        
        // Blog Post Status Management
        Route::patch('/{post}/publish', [BlogPostController::class, 'publish'])->name('publish');
        Route::patch('/{post}/unpublish', [BlogPostController::class, 'unpublish'])->name('unpublish');
        Route::patch('/{post}/archive', [BlogPostController::class, 'archive'])->name('archive');
        });

        // Comment Management
        Route::prefix('comments')->name('comments.')->group(function () {
            Route::post('/{post}/comments', [BlogCommentController::class, 'store'])->name('store');
            Route::put('/comments/{comment}', [BlogCommentController::class, 'update'])->name('update');
            Route::delete('/comments/{comment}', [BlogCommentController::class, 'destroy'])->name('delete');
        });

        // Reactions
        Route::post('/posts/{post}/react', [BlogReactionController::class, 'react'])->name('react');
        Route::delete('/posts/{post}/react', [BlogReactionController::class, 'unreact'])->name('unreact');

    });
});


Route::middleware(['sso.auth'])->group(function () {
    Route::post('/posts/{post}/react', [BlogReactionController::class, 'react'])->name('posts.react');
    Route::delete('/posts/{post}/unreact', [BlogReactionController::class, 'unreact'])->name('posts.unreact');
});


// Public Blog Routes
Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/public', [BlogPostController::class, 'publicIndex'])->name('public.view');
    Route::get('/guests', [BlogPostController::class, 'guestUserBlogs'])->name('guest.user');
    Route::get('/{post}', [BlogPostController::class, 'show'])->name('show');
    Route::get('/categories/{category}', [BlogCategoryController::class, 'show'])->name('categories.show');
});

// CompanyJob Management Routes
Route::middleware(['sso.auth'])->group(function () {
    Route::prefix('jobs')->middleware('check.app.roles:super-admin')->name('jobs.')->group(function () {
        Route::get('/', [CompanyJobController::class, 'index'])->name('index');
        Route::get('/create', [CompanyJobController::class, 'create'])->name('create');
        Route::post('/', [CompanyJobController::class, 'store'])->name('store');
        Route::get('/{job}', [CompanyJobController::class, 'show'])->name('show');
        Route::get('/{job}/edit', [CompanyJobController::class, 'edit'])->name('edit');
        Route::put('/{job}', [CompanyJobController::class, 'update'])->name('update');
        Route::delete('/{job}', [CompanyJobController::class, 'destroy'])->name('destroy');
        Route::patch('/{job}/publish', [CompanyJobController::class, 'publish'])->name('publish');
        Route::patch('/{job}/close', [CompanyJobController::class, 'close'])->name('close');
        Route::get('/listings', [CompanyJobController::class, 'jobListings'])->name('listings');
    });
     // CompanyJob Applications
        Route::get('/applications/dashboard', [JobApplicationController::class, 'index'])->name('applications.index')->middleware('check.app.roles:super-admin,admin');
        Route::get('/{job}/apply', [JobApplicationController::class, 'create'])->name('applications.create');
        Route::post('/{job}/apply', [JobApplicationController::class, 'store'])->name('applications.store');
        Route::get('/applications/{application}', [JobApplicationController::class, 'show'])->name('applications.show')->middleware('check.app.roles:super-admin,admin');
        Route::get('/applications/{application}/delete', [JobApplicationController::class, 'destroy'])->name('applications.destroy');
        Route::delete('user/applications/{application}/withdraw', [JobApplicationController::class, 'withdraw'])->name('user.application.withdraw');
        Route::put('/applications/{application}/status', [JobApplicationController::class, 'updateStatus'])->name('applications.update-status')->middleware('check.app.roles:super-admin,admin');
        Route::get('/applications/{application}/resume', [JobApplicationController::class, 'downloadResume'])->name('applications.resume');
        Route::get('/applications/{application}/cover-letter', [JobApplicationController::class, 'downloadCoverLetter'])->name('applications.cover-letter');
        Route::get('/applications/{application}/user-specific', [JobApplicationController::class, 'userSpecificApplication'])->name('user.application.specific.show');
        Route::get('/user-applications', [JobApplicationController::class, 'myApplications'])->name('user.applications.all');
        Route::get('user-application/{application}/edit', [JobApplicationController::class, 'showEditUserApplicationForm'])->name('user.application.edit');
        Route::put('user-application/{application}', [JobApplicationController::class, 'updateUserApplication'])->name('user.application.update');
     
});
        Route::middleware(['auth'])->group(function () {
            Route::get('list/jobs', [CompanyJobController::class, 'jobListings'])->name('jobs.listings');
        });
        





    Route::prefix('plans')->middleware(['sso.auth','check.app.roles:super-admin'])->name('plans.')->group(function () {
        Route::get('/create', [PlanController::class, 'create'])->name('create');
        Route::get('/', [PlanController::class, 'index'])->name('index');
        Route::get('/{id}', [PlanController::class, 'show'])->name('show');
        Route::post('/', [PlanController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [PlanController::class, 'edit'])->name('edit');
        Route::put('/{id}', [PlanController::class, 'update'])->name('update');
        Route::delete('/{id}', [PlanController::class, 'destroy'])->name('destroy');

    // Managing features of a specific plan
    Route::prefix('{plan}/features')->name('features.')->group(function () {
        Route::get('/create', [PlanFeatureController::class, 'create'])->name('create');
        Route::get('/', [PlanFeatureController::class, 'index'])->name('index');
        Route::get('/{feature}', [PlanFeatureController::class, 'show'])->name('show');
        Route::post('/', [PlanFeatureController::class, 'store'])->name('store');
        Route::get('/{feature}/edit', [PlanFeatureController::class, 'edit'])->name('edit');
        Route::delete('/{feature}/detach', [PlanFeatureController::class, 'detach'])->name('detach');
        Route::put('/{feature}', [PlanFeatureController::class, 'update'])->name('update');
        Route::delete('/{feature}', [PlanFeatureController::class, 'destroy'])->name('destroy');
    });
});


// routes/api.php

use App\Http\Controllers\FeaturePlanController;

Route::post('/plans/{plan}/features/sync', [PlanFeatureController::class, 'syncFeatures'])->middleware(['sso.auth', 'check.app.roles:super-admin']);

use App\Http\Controllers\SubscriptionController;
Route::prefix('subscriptions')->middleware(['sso.auth'])->group(function () {
    Route::get('/', [SubscriptionController::class, 'index']);
    Route::get('{id}', [SubscriptionController::class, 'show']);
    Route::post('/', [SubscriptionController::class, 'store']);
    Route::put('{id}', [SubscriptionController::class, 'update']);
    Route::delete('{id}', [SubscriptionController::class, 'destroy']);
});

Route::prefix('subscriptions/{subscription}')->middleware(['sso.auth','check.app.roles:super-admin'])->group(function () {
    Route::post('/activate', [SubscriptionController::class, 'activate']);
    Route::post('/cancel', [SubscriptionController::class, 'cancel']);
    Route::post('/renew', [SubscriptionController::class, 'renew']);
});


use App\Http\Controllers\PaymentController;

Route::Resource('payments', PaymentController::class)->only(['store', 'index', 'show'])->middleware(['sso.auth']);

/**
 * Product pricing
 */
Route::view('/pricing/custosell','pricing.dashboard.custosell')->name('dashbaord.pricing.custosell');
Route::view('/pricing/custospace','pricing.dashboard.custospace')->name('dashbaord.pricing.custospace');
Route::view('/pricing/custohost','pricing.dashboard.custohost')->name('dashbaord.pricing.custohost');

Route::view('payment/success', 'payment.payment_success')->name('payment.success');
Route::view('payment/failed', 'payment.payment_failed')->name('payment.failed');
Route::view('payment/processing', 'payment.payment_processing')->name('payment.processing');
Route::view('payment/checkout', 'payment.payment_checkout')->name('payment.checkout');
Route::post('payment/process',function () {
    return redirect()->route('payment.processing');
})->name('payment.process');
Route::get('application-proceed',[JobApplicationController::class,'applicationProceed'])->name('application.proceed');

 

require __DIR__ . '/central.php';
require __DIR__ . '/auth.php';
