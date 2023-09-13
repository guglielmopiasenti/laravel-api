<?php

use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ProjectController;
use App\Models\Project;
use Illuminate\Http\Request;
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

Route::get('/projects', function () {
    $projects = Project::all();
    return response()->json($projects);
});

// route to get the projects's list
Route::apiResource('projects', ProjectController::class);

// route to get a project detail
Route::get('/projects/{project}', [ProjectController::class, 'show']);

// route to get message and mail
Route::post('/contact-message', [ContactController::class, 'message']);