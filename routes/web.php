<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortLinkController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'AuthController@loginPage')->name('login');
Route::post('/auth/login', 'AuthController@login');
Route::post('/auth/register', 'AuthController@register');

Route::group([
    'middleware' => 'auth:web',
], function ($router) {
    Route::get('/', 'ShortLinkController@index');
    Route::get('/short-link/datatable', 'ShortLinkController@datatable');
    Route::post('/short-link/delete', 'ShortLinkController@delete');
    Route::post('/generate-shorten-link', 'ShortLinkController@store')->name('generate.shorten.link.post');

    Route::get('/{code}', 'ShortLinkController@shortenLink')->name('shorten.link');
});
