<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin'], function () {

    Route::post('top-ups/user', 'TopUpApiController@top_up_user')->middleware('ip_blocker:whitelist')->name('top-ups.top_up_user'); // 用户请求充值
    // Route::get('top-ups/user', 'TopUpApiController@edit_top_up_user')->name('top-ups.edit_top_up_user'); //详细付款页面
    Route::post('top-ups/user/update', 'TopUpApiController@update_top_up_user')->name('top-ups.update_top_up_user'); //详细付款页面 用户更新资料

    Route::post('payout/user', 'PayoutApiController@payout_user')->middleware('ip_blocker:whitelist')->name('payout.payout_user');

    Route::get('wallet/{id}', 'UsersApiController@wallet')->name('wallet.wallet'); //钱包

    Route::post('callback_test', 'PayoutApiController@callback_test')->name('payout.callback_test'); //測試callback

    Route::post('encrypt', 'PayoutApiController@encrypt')->name('payout.encrypt'); //測試數據加密
    Route::post('decrypt', 'PayoutApiController@decrypt')->name('payout.decrypt'); //測試數據解密

    // Balances
    Route::put('balances/balance_settle', 'BalanceApiController@balance_settle')->name('balances.balance_settle'); // balance settle

    Route::post('top-ups/user2', 'TopUpApiController@top_up_user2')->name('top-ups.top_up_user2'); // 用户请求充值（加密）

    Route::group(['middleware' => ['auth:sanctum']], function () {
        // Permissions
        Route::apiResource('permissions', 'PermissionsApiController');

        // Roles
        Route::apiResource('roles', 'RolesApiController');

        // Users
        Route::apiResource('users', 'UsersApiController');

        // Admins
        Route::apiResource('admins', 'AdminApiController');

        // Merchants
        Route::apiResource('merchants', 'MerchantApiController');

        // Partners
        Route::apiResource('partners', 'PartnerApiController');

        // Deposits
        Route::apiResource('deposits', 'DepositApiController');

        // Payouts
        Route::post('payouts/media', 'PayoutApiController@storeMedia')->name('payouts.storeMedia');
        Route::apiResource('payouts', 'PayoutApiController');

        // Payout Bulks
        Route::post('payout-bulks/media', 'PayoutBulkApiController@storeMedia')->name('payout-bulks.storeMedia');
        Route::apiResource('payout-bulks', 'PayoutBulkApiController');

        // Currencies
        Route::apiResource('currencies', 'CurrencyApiController');

        // Payout Banks
        Route::apiResource('payout-banks', 'PayoutBankApiController');

        // Settlements
        Route::post('settlements/media', 'SettlementApiController@storeMedia')->name('settlements.storeMedia');
        Route::apiResource('settlements', 'SettlementApiController');

        // Settlement Banks
        Route::apiResource('settlement-banks', 'SettlementBankApiController');

        // Balances
        Route::apiResource('balances', 'BalanceApiController');

        // Top Ups
        Route::post('top-ups/media', 'TopUpApiController@storeMedia')->name('top-ups.storeMedia');
        Route::apiResource('top-ups', 'TopUpApiController');

        // Api Keys
        Route::apiResource('api-keys', 'ApiKeyApiController');

        // Saving Accounts
        Route::apiResource('saving-accounts', 'SavingAccountApiController');

        // Gate Saving Accounts
        Route::apiResource('gate-saving-accounts', 'GateSavingAccountApiController');

        // Whitelist Ip Addresses
        Route::apiResource('whitelist-ip-addresses', 'WhitelistIpAddressApiController');

        // Products
        Route::apiResource('products', 'ProductApiController');

        // Whitelist Emails
        Route::apiResource('whitelist-emails', 'WhitelistEmailApiController');
    });
});
