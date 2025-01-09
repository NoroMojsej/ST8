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
use App\Http\Controllers\PaperController;
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
Route::get('/user/list', [UserController::class, 'getUsersList']);
Route::put('/user/changeRole/{userId}', [UserController::class, 'changeRole']);
Route::get('/user/{userId}', [UserController::class, 'getUserInfo']);
Route::put('/user/changePassword/{userId}', [UserController::class, 'changePassword']);
Route::put('/updateUser/{userId}', [UserController::class, 'update']);
Route::get('/countries', [CountryController::class, 'getAllcountries']);
Route::get('/degrees', [DegreeController::class, 'index']);
Route::get('/universities', [UniversityController::class, 'getAllUniversities']);
Route::get('/universities/{countryId}', [UniversityController::class, 'getUniversityByCountry']);
//Route::get('/faculties/{universityId}', [FacultyController::class, 'getFaculties']);
//Route::get('/departments/{facultyId}', [DepartmentController::class, 'getDepartments']);
Route::get('/reviews/get-all-reviews', [ReviewController::class, 'getAllReviews']);
Route::get('/reviews/get-review/{id}', [ReviewController::class, 'getReviewById']);
Route::post('/reviews/save-review', [ReviewController::class, 'saveReview']);
Route::post('/reviews/delete-review', [ReviewController::class, 'deleteReview']);
Route::get('/conferences', [ConferenceController::class, 'index']);
Route::post('/createConf', [ConferenceController::class, 'store']);
Route::get('/conferences/active', [ConferenceController::class, 'getActiveConferences']);
Route::put('/conference/update/{conferenceId}', [ConferenceController::class, 'updateConference']);
Route::get('/conferences/{conferenceId}', [ConferenceController::class, 'show']);
Route::get('/conferences/download-all/{conferenceId}', [ConferenceController::class, 'downloadAllFiles']);
Route::get('/conferences/download-approved/{conferenceId}', [ConferenceController::class, 'downloadApprovedPapers']);
Route::get('/conferences/download-refused/{conferenceId}', [ConferenceController::class, 'downloadRefusedPapers']);
Route::get('/conferences/{conferenceId}/papers/{paperId}/download', [ConferenceController::class, 'downloadPaperFiles']);
Route::put('/conference/{conferenceId}', [ConferenceController::class, 'update']);
Route::get('/papers/get-all-papers', [PaperController::class, 'getAllPapers']);
Route::get('/papers/get-all-papers-and-their-review', [PaperController::class, 'getAllPapersAndTheirReview']);
Route::get('/papers/get-all-papers-and-their-review-by-assigned-userid-to-review/{assignedUserIdToReview}', [PaperController::class, 'getAllPapersAndTheirReviewByAssignedUserIdToReview']);
Route::get('/papers/available/{idConference}/{idSection}', [PaperController::class, 'getPapersAvailable']);
Route::post('/papers/assign/{userId}', [ReviewController::class, 'createReviewAndUpdatePaper']);  
Route::get('/papers/{idEssay}', [PaperController::class, 'getPaperById']);
Route::get('/papers/{idEssay}/review', [PaperController::class, 'getReviewByPaper']);
Route::get('/papers/student/{studentId}', [PaperController::class, 'getUserPapers']);
Route::get('/papers/student/{studentId}/conference/{conferenceId}', [PaperController::class, 'getEssaysByStudentAndConference']);
Route::put('/papers/update/{essayId}', [PaperController::class, 'updateEssayByID']);
Route::post('/papers/update/{essayId}/upload-files', [PaperController::class, 'uploadFiles']);
Route::get('/sections/get-all-sections', [SectionController::class, 'getAllSections']);
Route::post('/sections/save-section', [SectionController::class, 'saveSection']);
Route::post('/sections/delete-section', [SectionController::class, 'deleteSection']);
Route::get('/sections/{idConference}', [SectionController::class, 'getSectionByConferenceId']);
// Upravte si routes ako chcete.
//Route::post('/upload-paper{userId}', [PaperController::class, 'uploadPaper'])->middleware('auth:sanctum'); // pre istotu aby vedeli len prihlásení ludia uploadovať
Route::post('/upload-paper/{userId}', [PaperController::class, 'uploadPaper']); // môže sa aj takto, ajtak ho to nepustí uploadnuť.
Route::post('/update-paper/{id}/{userId}', [PaperController::class, 'updatePaper']); // PUT z nejakého dôvodu nefunguje s file-uploadom, zmena na post.
Route::delete('/delete-paper/{id}/{userId}', [PaperController::class, 'deletePaper']); // mazanie papers (non-admin).
Route::get('/papers/conference/{conferenceId}', [PaperController::class, 'getPapersByConference']); // papers pre danú konferenciu.

Route::post('/faculties/create', [FacultyController::class, 'create']);
Route::get('/faculties/{universityId}', [FacultyController::class, 'getFaculties']); // getByUniversity
Route::get('/faculties/getfaculty/{id}', [FacultyController::class, 'getById']); // getById
Route::post('/faculties/update/{id}', [FacultyController::class, 'update']);
Route::delete('/faculties/delete/{id}', [FacultyController::class, 'deleteById']);

Route::post('/departments/create', [DepartmentController::class, 'create']); // Create department
Route::get('/departments/{facultyId}', [DepartmentController::class, 'getDepartments']); //
Route::get('/departments/getdepartment/{id}', [DepartmentController::class, 'getById']); // Get department by ID
Route::post('/departments/update/{id}', [DepartmentController::class, 'update']); // Edit department by ID
Route::delete('/departments/deletedepartment/{id}', [DepartmentController::class, 'deleteById']); // Remove department by ID

Route::post('/universities/create', [UniversityController::class, 'create']);
Route::get('/universities/university/{id}', [UniversityController::class, 'getById']);
Route::post('/universities/update/{id}', [UniversityController::class, 'update']);
