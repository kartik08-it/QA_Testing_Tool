<?php

// routes/web.php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TestCaseController;
use App\Http\Controllers\TestRunController;
use App\Http\Controllers\TestSuiteController;
use App\Http\Controllers\DefectController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Projects
    Route::resource('projects', ProjectController::class);

    // Project-specific routes
    Route::prefix('projects/{project}')->name('projects.')->group(function () {
        
        // Test Suites
        Route::resource('test-suites', TestSuiteController::class);

        // Test Cases
        Route::get('test-cases', [TestCaseController::class, 'index'])->name('test-cases.index');
        Route::get('test-cases/create', [TestCaseController::class, 'create'])->name('test-cases.create');
        Route::post('test-cases', [TestCaseController::class, 'store'])->name('test-cases.store');
        Route::get('test-cases/{testCase}', [TestCaseController::class, 'show'])->name('test-cases.show');
        Route::get('test-cases/{testCase}/edit', [TestCaseController::class, 'edit'])->name('test-cases.edit');
        Route::put('test-cases/{testCase}', [TestCaseController::class, 'update'])->name('test-cases.update');
        Route::delete('test-cases/{testCase}', [TestCaseController::class, 'destroy'])->name('test-cases.destroy');
        
        // Bulk operations
        Route::post('test-cases/bulk-delete', [TestCaseController::class, 'bulkDelete'])->name('test-cases.bulk-delete');
        Route::post('test-cases/export', [TestCaseController::class, 'export'])->name('test-cases.export');
        Route::post('test-cases/import', [TestCaseController::class, 'import'])->name('test-cases.import');

        // Test Runs
        Route::get('test-runs', [TestRunController::class, 'index'])->name('test-runs.index');
        Route::get('test-runs/create', [TestRunController::class, 'create'])->name('test-runs.create');
        Route::post('test-runs', [TestRunController::class, 'store'])->name('test-runs.store');
        Route::get('test-runs/{testRun}', [TestRunController::class, 'show'])->name('test-runs.show');
        Route::get('test-runs/{testRun}/execute', [TestRunController::class, 'execute'])->name('test-runs.execute');
        Route::put('test-runs/{testRun}/executions/{execution}', [TestRunController::class, 'updateExecution'])->name('test-runs.update-execution');
        Route::delete('test-runs/{testRun}', [TestRunController::class, 'destroy'])->name('test-runs.destroy');

        // Defects
        Route::resource('defects', DefectController::class);
        Route::post('defects/{defect}/status', [DefectController::class, 'updateStatus'])->name('defects.update-status');

        // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/coverage', [ReportController::class, 'coverage'])->name('reports.coverage');
        Route::get('reports/execution', [ReportController::class, 'execution'])->name('reports.execution');
        Route::get('reports/defects', [ReportController::class, 'defects'])->name('reports.defects');
    });
});

require __DIR__.'/auth.php';