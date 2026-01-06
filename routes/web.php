<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/test', function () {
//     return view('/landing/layouts/app');
// });

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/team/{slug}', [LandingController::class, 'teamDetail'])->name('team.detail');
// Route::get('/news', [NewsController::class, 'all'])->name('news.all');
Route::get('/news/{slug}', [LandingController::class, 'detail'])->name('news.detail');
Route::get('/news', [LandingController::class, 'news'])->name('news');

// ADMIN
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'webLogin']);
Route::post('/logout', [AuthController::class, 'webLogout'])->name('logout');


Route::middleware(['loginrequired'])->get('/admin', function() {
    return redirect()->route('admin.news.index');
});
Route::middleware(['loginrequired'])->prefix('admin/news')->name('admin.news.')->group(function() {
    Route::resource('/', NewsController::class)->parameters(['' => 'id']);
});
Route::post('/admin/ckeditor/upload', [\App\Http\Controllers\NewsController::class, 'uploadEditorImage'])->name('admin.ckeditor.upload');

// CMS ADMIN ROUTES
Route::middleware(['loginrequired'])->prefix('admin/cms')->name('admin.cms.')->group(function() {
    Route::get('/', function() {
        return redirect()->route('admin.cms.pages.index');
    });
    
    // Pages management
    Route::get('/pages', function() {
        return view('admin.cms.pages.index');
    })->name('pages.index');
    
    Route::get('/pages/create', function() {
        return view('admin.cms.pages.create');
    })->name('pages.create');
    
    Route::get('/pages/{id}/edit', function($id) {
        return view('admin.cms.pages.edit', ['pageId' => $id]);
    })->name('pages.edit');
    
    // Analytics dashboard
    Route::get('/analytics', function() {
        return view('admin.cms.analytics.index');
    })->name('analytics.index');
    
    // Preview
    Route::get('/preview/{id}', function($id) {
        return view('admin.cms.preview.index', ['pageId' => $id]);
    })->name('preview.index');
});

