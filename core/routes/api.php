<?php

use App\User;
use App\Ticket;
use App\Models\EasyForm;
use Illuminate\Http\Request;
use App\Http\Controllers\API\DigitalSystemController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('easy-forms')->group(function () {
    Route::get('digital/{key}', function ($key) {
        if(trim($key) != md5('Angel')) return abort(403);

        // dd(EasyForm::first());

        return EasyForm::count() >= 1 ? ['easy_form_server_url' => html_entity_decode(EasyForm::first()->easy_form_server_url), 'easy_form_digital' => html_entity_decode(EasyForm::first()->easy_form_digital)] : new EasyForm();
    });
    Route::post('digital-ticket/{user_id}/{key}', 'API\DigitalSystemController@digital_ticket');
});
