<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\S3ExampleController;

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

Route::get('/', [UserController::class, 'getUser'])->name('user.get');
Route::get('/user', [UserController::class, 'show'])->name('user.show');

/*
|----------------------------------------------
| S3 service
|----------------------------------------------
*/
Route::group([
    'as' => 's3.',
    'prefix' => 's3',
    'controller' => S3ExampleController::class,
], function () {
    Route::post('upload', 'upLoadImageToS3')->name('s3.upload');
    Route::delete('delete', 'deleteImageFromS3')->name('s3.delete');
});
