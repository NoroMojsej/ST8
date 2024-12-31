<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\DegreeController;
use App\Http\Controllers\UniversityController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\ShowPaperController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->get('user', [LoginController::class, 'user']);
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/user/{userId}', [UserController::class, 'getUserInfo']);
Route::put('/user/changePassword/{userId}', [UserController::class, 'changePassword']);
Route::put('/updateUser/{userId}', [UserController::class, 'update']);
Route::get('/countries', [CountryController::class, 'countries']);
Route::get('/degrees', [DegreeController::class, 'index']);
Route::get('/universities', [UniversityController::class, 'index']);
Route::get('/universities/{countryId}', [UniversityController::class, 'getByCountry']);
Route::get('/faculties/{universityId}', [FacultyController::class, 'getFaculties']);
Route::get('/departments/{facultyId}', [DepartmentController::class, 'getDepartments']);
Route::post('/submit-review', [ReviewController::class, 'submitReview']);
Route::get('/sections', [SectionController::class, 'index']);
Route::get('/conferences', [ConferenceController::class, 'index']);
Route::post('/createConf', [ConferenceController::class, 'store']);
Route::get('/conferences/{conferenceId}', [ConferenceController::class, 'show']);
Route::put('/conference/{conferenceId}', [ConferenceController::class, 'update']);
Route::get('/papers/conference/{conferenceId}', [ShowPaperController::class, 'getPapersByConference']);
Route::get('/papers/student/{studentId}/conference/{conferenceId}', [ShowController::class, 'getEssaysByStudentAndConference']);
