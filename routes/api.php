<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ElectiveController;
use App\Http\Controllers\ElectiveSubjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserController;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);

Route::get('profiles/images/{image}', [ProfileController::class, 'getProfilePic']);

Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);

Route::get('content/logo/{logo}', [ContentController::class, 'getLogo']);
Route::get('subjectsGetSyllabus/{file}', [SubjectController::class, 'getSyllabus']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('contents', [ContentController::class, 'getContent']);
    Route::apiResource('departments', DepartmentController::class);
    Route::apiResource('users', UserController::class);
    Route::post('users/changePass', [UserController::class, 'changePassword']);

    Route::post('content', [ContentController::class, 'updateContent']);
    Route::post('content-init', [ContentController::class, 'initContent']);

    Route::post('subjectsUpdateSyllabus/{id}', [SubjectController::class, 'updateSyllabus']);
    Route::post('subjects/update/{id}', [SubjectController::class, 'updateSubject']);
    Route::apiResource('subjects', SubjectController::class);
    Route::apiResource('electiveSubjects', ElectiveSubjectController::class);

    Route::post('electives/update/{id}', [ElectiveController::class, 'updateSubject']);
    Route::apiResource('electives', ElectiveController::class);

    Route::post('profiles/upload', [ProfileController::class, 'uploadPic']);
    Route::apiResource('profiles', ProfileController::class);

    Route::post('curriculums/approve/{id}', [CurriculumController::class, 'approveCurriculum']);
    Route::post('curriculums/submitRevision', [CurriculumController::class, 'submitRevision']);
    Route::patch('curriculums/updateRevision', [CurriculumController::class, 'updateRevision']);
    Route::post('curriculums/approveRevision/{id}', [CurriculumController::class, 'approveRevision']);
    Route::get('curriculums/revisions', [CurriculumController::class, 'curriculumRevisionList']);
    Route::get('curriculums/revisions/{id}', [CurriculumController::class, 'curriculumRevision']);
    Route::apiResource('curriculums', CurriculumController::class);

    Route::apiResource('comments', CommentController::class);

    Route::post('register', [AuthController::class, 'register']);
    Route::post('getUser', [AuthController::class, 'getUser']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
