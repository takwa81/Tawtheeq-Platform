<?php

use App\Http\Controllers\Dashboard\{
    BranchController,
    BranchManagerController,
    CompanyController,
    UserAuthController,
    UserController,
};
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::middleware(['set_language'])->group(function () {

    Route::get('/secure-file/{folder}/{filename}', function ($folder, $filename) {
        if (!auth()->check()) {
            // return view('errors.403');
        }

        $path = storage_path("app/public/{$folder}/" . $filename);

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->file($path);
    });

    Route::get('files/{folder}/{filename}', function ($folder, $filename) {
        $path = storage_path('app/private/' . $folder . '/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    })->name('files');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('login-form');
        Route::post('login', [UserAuthController::class, 'login'])->name('login');
    });


    Route::get('/', function () {
        return redirect()->route('dashboard.home');
    });

    Route::prefix('dashboard')->name('dashboard.')->middleware(['custom.auth'])->group(function () {

        Route::get('/home', function () {
            return view('home');
        })->name('home');

        Route::resource('companies', CompanyController::class);

        Route::resource('branch_managers', BranchManagerController::class);
        Route::post('branch_managers/{id}/restore', [BranchManagerController::class, 'restore'])->name('branch_managers.restore');
        Route::get('branch_managers/activate/{id}', [BranchManagerController::class, 'activate'])->name('branch_managers.activate');
        Route::get('branch_managers/deactivate/{id}', [BranchManagerController::class, 'deactivate'])->name('branch_managers.deactivate');
        Route::post('users/change-password', [UserController::class, 'changePassword'])->name('users.change_password');

        Route::resource('branches', BranchController::class);
        Route::post('branches/{id}/restore', [BranchController::class, 'restore'])->name('branches.restore');
        Route::get('branches/activate/{id}', [BranchController::class, 'activate'])->name('branches.activate');
        Route::get('branches/deactivate/{id}', [BranchController::class, 'deactivate'])->name('branches.deactivate');


        Route::post('logout', [UserAuthController::class, 'logout'])->name('logout');

        Route::get('/clear-cache', function () {
            Artisan::call('optimize:clear');
            toastr()->success('تم مسح الكاش بنجاح.');
            return redirect()->back();
        })->name('clear.cache');


        // Route::get('configs', [ConfigController::class, 'edit'])->name('configs.edit');
        // Route::post('configs', [ConfigController::class, 'update'])->name('configs.update');
    });
});
