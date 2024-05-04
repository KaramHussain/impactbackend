<?php

use Illuminate\Support\Facades\Route;

Route::post('login', 'admin\adminLoginController@login');

Route::post('me', 'admin\adminLoginController@me');

Route::post('forgot-password', 'admin\ForgotPasswordController@sendResetPasswordLink');

Route::get('token-exists', 'admin\ForgotPasswordController@checkIfResetTokenExists');

Route::post('reset-password', 'admin\ForgotPasswordController@resetPassword');

Route::post('fetch-chart-data', 'admin\chartsController@index');

Route::post('members', 'admin\membersController@index');

Route::post('top-performers', 'admin\membersController@get_top_performers');

Route::post('get-members', 'admin\membersController@get_members');

Route::post('get-member-profile', 'admin\memberProfileController@index');