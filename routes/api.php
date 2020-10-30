<?php

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::get('/tokens', ['as' => 'tokens', 'uses' => 'AuthController@tokens', 'middleware' => 'auth:sanctum']);

    Route::post('/login', ['uses' => 'AuthController@login', 'as' => 'login']);

    Route::post('/logout', ['uses' => 'AuthController@logout', 'as' => 'logout', 'middleware' => ['auth:sanctum']]);

    Route::post('/revoke/{id}', ['as' => 'revoke', 'uses' => 'AuthController@revoke', 'middleware' => ['auth:sanctum', 'exists:personal_access_tokens|id|id']]);
});

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::group(['prefix' => 'password', 'as' => 'password.'], function () {
        Route::post('/lost', ['as' => 'lost', 'uses' => 'ForgotPasswordController@lost']);

        Route::post('/reset/{token}', ['as' => 'reset', 'uses' => 'ForgotPasswordController@reset']);
    });

    Route::post('/', ['as' => 'register', 'uses' => 'UserController@register']);

    Route::put('/profile', ['uses' => 'UserController@profileUpdate', 'as' => 'users.profile.update'])->middleware('auth:sanctum');

    Route::get('/verify/{id}', ['as' => 'verify', 'uses' => 'UserController@verify'])->middleware(['signed', 'exists:users|id|id|deleted_at']);

    Route::get('/profile', ['as' => 'profile', 'uses' => 'UserController@profile'])->middleware('auth:sanctum');
});
