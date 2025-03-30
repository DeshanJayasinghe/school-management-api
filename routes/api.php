<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\GradeController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\NotificationController;

// Public routes (no auth)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/notify', [NotificationController::class, 'sendNotification']);

// Protected routes (require Sanctum token)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Classes
    Route::apiResource('classes', ClassController::class);
    Route::post('classes/{class}/enroll', [ClassController::class, 'enrollStudent']);
    Route::post('classes/{class}/unenroll', [ClassController::class, 'unenrollStudent']);

    // Grades
    Route::apiResource('grades', GradeController::class);

    // Student-specific routes
    Route::middleware([RoleMiddleware::class . ':student'])->group(function () {
         Route::get('/student/classes', [StudentController::class, 'getMyClasses']);
    Route::get('/student/grades', [StudentController::class, 'getMyGrades']);
    Route::get('/student/grades/export', [StudentController::class, 'exportGradesPdf']);
    });

    // Admin-only routes
    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        Route::get('/users', function () {
            return \App\Models\User::all();
        });
    });
});