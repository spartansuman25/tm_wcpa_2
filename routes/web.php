<?php

use App\Http\Controllers\Admin\MatchesController;
use App\Http\Controllers\Admin\PredictionsController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\TeamsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PermissionsController;

Route::get('/', function () { return redirect('/admin/home'); });

// Authentication Routes...
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');;
Route::post('/login', [LoginController::class, 'login'])->name('auth.login');
Route::post('/logout', [LoginController::class, 'logout'])->name('auth.logout');



#todo
// Change Password Routes...
Route::get('/change_password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('auth.change_password');
Route::patch('/change_password',  [ChangePasswordController::class, 'changePassword'])->name('auth.change_password');

// Password Reset Routes...
Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('auth.password.reset');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('auth.password.reset');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('auth.password.reset');

// Registration Routes..
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('auth.register');
Route::post('/register', [RegisterController::class, 'register'])->name('auth.register');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::resource('/permissions', PermissionsController::class);
    Route::post('/permissions_mass_destroy', ['uses' =>  [PermissionsController::class, 'massDestroy'], 'as' => 'permissions.mass_destroy']);
    Route::resource('/roles', RolesController::class);
    Route::post('/roles_mass_destroy', ['uses' =>  [RolesController::class, 'massDestroy'], 'as' => 'roles.mass_destroy']);
    Route::resource('/users',  UsersController::class);
    Route::post('/users_mass_destroy', ['uses' => [RolesController::class, 'massDestroy'], 'as' => 'users.mass_destroy']);
    Route::resource('/teams', TeamsController::class);
    Route::post('/teams_mass_destroy', ['uses' =>  [TeamsController::class, 'massDestroy'], 'as' => 'teams.mass_destroy']);
    Route::post('/teams_restore/{id}', ['uses' =>  [TeamsController::class, 'restore'], 'as' => 'teams.restore']);
    Route::delete('/teams_perma_del/{id}', ['uses' =>  [TeamsController::class, 'perma_del'], 'as' => 'teams.perma_del']);
    Route::resource('/matches', MatchesController::class);
    Route::get('/matches/predict/{match_id}',  [MatchesController::class, 'predict'])->name('matches.predict');
    Route::post('/matches/predict/{match_id}',  [MatchesController::class, 'postPredict'])->name('matches.post_predict');
    Route::post('/matches_mass_destroy', ['uses' =>  [MatchesController::class, 'massDestroy'], 'as' => 'matches.mass_destroy']);
    Route::post('/matches_restore/{id}', ['uses' =>  [MatchesController::class, 'massDestroy'], 'as' => 'matches.restore']);
    Route::delete('/matches_perma_del/{id}', ['uses' =>  [MatchesController::class, 'postPredict'], 'as' => 'matches.perma_del']);
    Route::resource('/predictions', PredictionsController::class);
    Route::post('/predictions_mass_destroy', ['uses' =>  [PredictionsController::class, 'massDestroy'], 'as' => 'predictions.mass_destroy']);
    Route::post('/predictions_restore/{id}', ['uses' =>  [PredictionsController::class, 'restore'], 'as' => 'predictions.restore']);
    Route::delete('/predictions_perma_del/{id}', ['uses' =>  [PredictionsController::class, 'perma_del'], 'as' => 'predictions.perma_del']);




});
