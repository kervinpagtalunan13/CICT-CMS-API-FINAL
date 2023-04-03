<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ElectiveSubjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);

Route::get('profiles/images/{image}', [ProfileController::class, 'getProfilePic']);
Route::apiResource('departments', DepartmentController::class);
Route::apiResource('users', UserController::class);

Route::post('forgot-password', [AuthController::class, 'forgotPassword']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('subjects', SubjectController::class);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('profiles/upload', [ProfileController::class, 'uploadPic']);

    Route::apiResource('profiles', ProfileController::class);
    Route::post('curriculums/approve/{id}', [CurriculumController::class, 'approveCurriculum']);
    Route::post('curriculums/submitRevision', [CurriculumController::class, 'submitRevision']);
    Route::post('curriculums/updateRevision', [CurriculumController::class, 'updateRevision']);
    Route::post('curriculums/approveRevision/{id}', [CurriculumController::class, 'approveRevision']);

    Route::apiResource('curriculums', CurriculumController::class);
    Route::apiResource('comments', CommentController::class);
    Route::apiResource('electiveSubjects', ElectiveSubjectController::class);

    Route::post('getUser', [AuthController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
