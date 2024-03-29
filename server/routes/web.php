<?php

use App\Mail\MyTestMail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('send-mail', function () {

    $details = [
        'title' => 'Mail from Codingspoint.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('epremyan.edgar.2001@mail.ru')->send(new \App\Mail\MyTestMail($details));

    dd("Email is Sent.");
});
