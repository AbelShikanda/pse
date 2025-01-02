<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\Api\ScheduleController;
=======
>>>>>>> 13b75d815679ffd73381c0dfde26250cc365014e

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

<<<<<<< HEAD
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/schedules/{type}', [ScheduleController::class, 'fetchSchedulesByType']); // Fetch all schedules
// Route::post('/update_schedule', [ScheduleController::class, 'update']); // Update a schedule

// Route::get('/test', function () {
//     return response()->json(['message' => 'API routes are working!']);
// });
=======
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
>>>>>>> 13b75d815679ffd73381c0dfde26250cc365014e
