<?php

//TODO: Analisar como o middleware "exists" vai funcionar para aplicar o scope gloal do filtro do owner

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

Route::get('debtors/{id}/payments/{year}/{month}', ['as' => 'debtors.payments', 'uses' => 'DebtorController@payments', 'middleware' => 'exists:debtors|id|id|deleted_at']);

Route::middleware('auth:sanctum')->group(function () {
    Route::group(['prefix' => 'cards', 'as' => 'cards.'], function () {
        Route::get('/', ['as' => 'get', 'uses' => 'CardController@get']);
        Route::post('/', ['as' => 'create', 'uses' => 'CardController@create']);
        Route::get('/{id}', ['as' => 'find', 'uses' => 'CardController@find', 'middleware' => 'exists:cards|id|id|deleted_at']);
    });

    Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
        Route::get('/', ['as' => 'get', 'uses' => 'TagController@get']);
        Route::post('/', ['as' => 'create', 'uses' => 'TagController@create']);
    });

    Route::group(['prefix' => 'debtors', 'as' => 'debtors.'], function () {
        Route::get('/', ['as' => 'get', 'uses' => 'DebtorController@get']);
        Route::post('/', ['as' => 'create', 'uses' => 'DebtorController@create']);
        Route::put('/{id}', ['as' => 'update', 'uses' => 'DebtorController@update', 'middleware' => 'exists:debtors|id|id|deleted_at']);
        Route::get('/{id}', ['as' => 'find', 'uses' => 'DebtorController@find', 'middleware' => 'exists:debtors|id|id|deleted_at']);
    });

    Route::group(['prefix' => 'debts', 'as' => 'debts.'], function () {
        Route::get('/', ['as' => 'get', 'uses' => 'DebtController@get']);
        Route::post('/', ['as' => 'create', 'uses' => 'DebtController@create']);
        Route::post('/{id}', ['as' => 'update', 'uses' => 'DebtController@update', 'middleware' => 'exists:debts|id|id|deleted_at']);
        Route::get('/{id}', ['as' => 'find', 'uses' => 'DebtController@find', 'middleware' => 'exists:debts|id|id|deleted_at']);
    });

    Route::group(['prefix' => 'payments', 'as' => 'payments.'], function () {
        Route::get('/', ['as' => 'get', 'uses' => 'PaymentController@get']);
        Route::get('/{id}', ['as' => 'find', 'uses' => 'PaymentController@find', 'middleware' => 'exists:payments|id|id|deleted_at']);
        Route::post('/{id}/toggle', ['as' => 'toggle.payment', 'uses' => 'PaymentController@togglePayment', 'middleware' => 'exists:payments|id|id|deleted_at']);
        Route::get('/debtors', ['as' => 'debtors', 'uses' => 'PaymentController@debtors']);
    });
});
