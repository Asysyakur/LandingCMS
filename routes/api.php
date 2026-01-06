<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CmsController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\PreviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require authentication)
Route::middleware(['api.auth'])->group(function () {
    
    // Authentication routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    
    // CMS Routes
    Route::prefix('cms')->group(function () {
        
        // Pages management
        Route::get('/pages', [CmsController::class, 'getPages']);
        Route::post('/pages', [CmsController::class, 'createPage']);
        Route::get('/pages/{id}', [CmsController::class, 'getPage']);
        Route::put('/pages/{id}', [CmsController::class, 'updatePage']);
        Route::delete('/pages/{id}', [CmsController::class, 'deletePage']);
        
        // Components management
        Route::get('/components', [CmsController::class, 'getComponents']);
        
        // Page components management
        Route::post('/pages/{pageId}/components', [CmsController::class, 'addPageComponent']);
        Route::put('/pages/{pageId}/components/{componentId}', [CmsController::class, 'updatePageComponent']);
        Route::delete('/pages/{pageId}/components/{componentId}', [CmsController::class, 'removePageComponent']);
        
        // Versioning
        Route::get('/pages/{pageId}/versions', [CmsController::class, 'getPageVersions']);
        Route::post('/pages/{pageId}/versions/{versionId}/restore', [CmsController::class, 'restorePageVersion']);
    });
    
    // Analytics routes
    Route::prefix('analytics')->group(function () {
        Route::get('/dashboard', [AnalyticsController::class, 'getAnalytics']);
        Route::get('/pages/{pageId}', [AnalyticsController::class, 'getPageAnalytics']);
    });
    
    // Preview routes
    Route::prefix('preview')->group(function () {
        Route::get('/pages/{pageId}', [PreviewController::class, 'getPreview']);
        Route::get('/pages/{pageId}/responsive', [PreviewController::class, 'getResponsivePreview']);
        Route::get('/components/{componentSlug}/schema', [PreviewController::class, 'getComponentSchema']);
        Route::post('/components/{componentSlug}/preview', [PreviewController::class, 'getComponentPreview']);
    });
});

// Public preview routes (no authentication required)
Route::get('/preview/public/{pageSlug}', [PreviewController::class, 'getPublicPreview']);

// Public analytics tracking (no authentication required)
Route::post('/analytics/track/{pageSlug}', [AnalyticsController::class, 'trackVisitor']);
