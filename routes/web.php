<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ResumeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    // Fetch latest 6 active opportunities
    $latestOpportunities = \App\Models\Opportunity::with('organization')
        ->approved()
        ->active()
        ->latest()
        ->take(6)
        ->get();


    // Fetch stats
    $stats = [
        'orgs' => \App\Models\User::where('role', 'organization')->count(),
        'students' => \App\Models\User::where('role', 'student')->count(),
        'opportunities' => \App\Models\Opportunity::approved()->count(),
    ];

    // --- AUTO-SYNC LOGIC START ---
    $sourceDir = base_path('database/public/images/partners');
    $destDir = public_path('images/partners');

    if (file_exists($sourceDir)) {
        if (!file_exists($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $sourceFiles = array_diff(scandir($sourceDir), ['.', '..']);
        foreach ($sourceFiles as $file) {
            $srcPath = $sourceDir . '/' . $file;
            $destPath = $destDir . '/' . $file;

            if (!file_exists($destPath) || filemtime($srcPath) > filemtime($destPath)) {
                @copy($srcPath, $destPath);
            }
        }

        $destFiles = array_diff(scandir($destDir), ['.', '..']);
        foreach ($destFiles as $file) {
            if (!in_array($file, $sourceFiles)) {
                @unlink($destDir . '/' . $file);
            }
        }
    }
    // --- AUTO-SYNC LOGIC END ---

    $directory = $destDir;
    $partners = collect();

    if (file_exists($directory)) {
        $files = \Illuminate\Support\Facades\File::files($directory);
        foreach ($files as $file) {
            $partners->push((object) [
                'organization_name' => pathinfo($file->getFilename(), PATHINFO_FILENAME),
                'logo' => 'images/partners/' . $file->getFilename()
            ]);
        }
    }

    return view('welcome', compact('latestOpportunities', 'stats', 'partners'));
})->name('home');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Public Opportunity Details
Route::get('/opportunities/{id}', [OpportunityController::class, 'show'])->name('opportunities.show');

// Protected Routes (Authenticated Users)
Route::middleware(['auth'])->group(function () {

    // Dashboard - Role-based redirect
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'organization') {
            return redirect()->route('organization.dashboard');
        }
        return redirect()->route('student.dashboard');
    })->name('dashboard');

    // Notifications Routes
    Route::post('/notifications/mark-as-read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

    // Chat Routes
    Route::post('/chat/message', [\App\Http\Controllers\ChatController::class, 'handleMessage'])->name('chat.message');
    Route::post('/chat/clear', [\App\Http\Controllers\ChatController::class, 'clearHistory'])->name('chat.clear');

    // Admin Routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'manageUsers'])->name('users.index');
        Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('users.toggle');

        Route::get('/opportunities', [AdminController::class, 'allOpportunities'])->name('opportunities.index');
        Route::get('/organizations/pending', [AdminController::class, 'pendingOrganizations'])->name('organizations.pending');
        Route::post('/organizations/{id}/approve', [AdminController::class, 'approveOrganization'])->name('organizations.approve');
        Route::post('/organizations/{id}/reject', [AdminController::class, 'rejectOrganization'])->name('organizations.reject');

        Route::get('/organizations/{id}', [AdminController::class, 'viewOrganization'])->name('organizations.show');
    });

    // Organization Routes
    Route::prefix('organization')->name('organization.')->group(function () {
        Route::get('/dashboard', [OrganizationController::class, 'dashboard'])->name('dashboard');
        Route::get('/opportunities', [OrganizationController::class, 'opportunities'])->name('opportunities.index');
        Route::get('/opportunities/create', [OpportunityController::class, 'create'])->name('opportunities.create');
        Route::post('/opportunities', [OpportunityController::class, 'store'])->name('opportunities.store');
        Route::get('/opportunities/{id}/edit', [OpportunityController::class, 'edit'])->name('opportunities.edit');
        Route::put('/opportunities/{id}', [OpportunityController::class, 'update'])->name('opportunities.update');
        Route::delete('/opportunities/{id}', [OpportunityController::class, 'destroy'])->name('opportunities.destroy');
        Route::get('/opportunities/{id}/applications', [OrganizationController::class, 'viewApplications'])->name('applications.index');
        Route::get('/applications', [OrganizationController::class, 'allApplications'])->name('applications.all');
        Route::patch('/applications/{id}/status', [OrganizationController::class, 'updateApplicationStatus'])->name('applications.update-status');

        Route::get('/profile/create', [OrganizationController::class, 'createProfile'])->name('profile.create');
        Route::post('/profile', [OrganizationController::class, 'storeProfile'])->name('profile.store');
        Route::get('/profile/edit', [OrganizationController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [OrganizationController::class, 'updateProfile'])->name('profile.update');
    });

    // Student Routes
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/opportunities', [OpportunityController::class, 'index'])->name('opportunities.index');
        Route::post('/opportunities/{id}/apply', [OpportunityController::class, 'apply'])->name('opportunities.apply');
        Route::get('/applications', [StudentController::class, 'applications'])->name('applications.index');

        Route::get('/profile/edit', [StudentController::class, 'editProfile'])->name('profile.edit');
        Route::put('/profile', [StudentController::class, 'updateProfile'])->name('profile.update');

        // Resume Builder & ATS Scorer (Interactive Version)
        Route::get('/resume', [ResumeController::class, 'index'])->name('resume.index');
        Route::get('/resume/create/{layout}', [ResumeController::class, 'create'])->name('resume.create');
        Route::get('/resume/edit/{id}', [ResumeController::class, 'edit'])->name('resume.edit');
        Route::post('/resume/update/{id}', [ResumeController::class, 'update'])->name('resume.update');
        Route::get('/resume/preview/{id}', [ResumeController::class, 'preview'])->name('resume.preview');
        Route::get('/resume/download/{id}', [ResumeController::class, 'download'])->name('resume.download');
        Route::get('/resume/check-match/{opportunityId}/{resumeId?}', [ResumeController::class, 'checkMatch'])->name('resume.check-match');
    });
});

// AI Career Roadmap Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/student/career-roadmap', [App\Http\Controllers\CareerController::class, 'roadmap'])->name('student.career.roadmap');
    Route::post('/student/career-roadmap/generate', [App\Http\Controllers\CareerController::class, 'generateRoadmap'])->name('student.career.generate');
});
