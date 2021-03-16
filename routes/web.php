<?php

Route::redirect('/', '/index');
// Route::get('/home', function () {
//     if (session('status')) {
//         return redirect()->route('admin.home')->with('status', session('status'));
//     }

//     return redirect()->route('admin.home');
// });

// Auth::routes(['register' => false]);

Route::group(['as' => 'admin.', 'namespace' => 'Admin'], function () {
    Route::get('login-admin', 'Auth\LoginController@showLoginForm')->name('login.show');
    Route::post('login-admin', 'Auth\LoginController@login')->name('login');
    Route::post('logout-admin', 'Auth\LoginController@logout')->name('logout');
});

Route::group(['as' => 'merchant.', 'namespace' => 'Merchant'], function () {
    Route::get('login-merchant', 'Auth\LoginController@showLoginForm')->name('login.show');
    Route::post('login-merchant', 'Auth\LoginController@login')->name('login');
    Route::post('logout-merchant', 'Auth\LoginController@logout')->name('logout');
});

Route::group(['as' => 'partner.', 'namespace' => 'Partner'], function () {
    Route::get('login-partner', 'Auth\LoginController@showLoginForm')->name('login.show');
    Route::post('login-partner', 'Auth\LoginController@login')->name('login');
    Route::post('logout-partner', 'Auth\LoginController@logout')->name('logout');
});



Route::group(['as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth:admin,merchant,partner']], function () {

    Route::get('index', 'HomeController@index')->name('home');
    // Route::get('transaction_report', 'HomeController@transaction_report')->name('home.transaction_report');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::post('permissions/parse-csv-import', 'PermissionsController@parseCsvImport')->name('permissions.parseCsvImport');
    Route::post('permissions/process-csv-import', 'PermissionsController@processCsvImport')->name('permissions.processCsvImport');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::post('roles/parse-csv-import', 'RolesController@parseCsvImport')->name('roles.parseCsvImport');
    Route::post('roles/process-csv-import', 'RolesController@processCsvImport')->name('roles.processCsvImport');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // Admins
    Route::delete('admins/destroy', 'AdminController@massDestroy')->name('admins.massDestroy');
    Route::post('admins/parse-csv-import', 'AdminController@parseCsvImport')->name('admins.parseCsvImport');
    Route::post('admins/process-csv-import', 'AdminController@processCsvImport')->name('admins.processCsvImport');
    Route::resource('admins', 'AdminController');

    // Merchants
    Route::delete('merchants/destroy', 'MerchantController@massDestroy')->name('merchants.massDestroy');
    Route::post('merchants/parse-csv-import', 'MerchantController@parseCsvImport')->name('merchants.parseCsvImport');
    Route::post('merchants/process-csv-import', 'MerchantController@processCsvImport')->name('merchants.processCsvImport');
    Route::resource('merchants', 'MerchantController');

    // Partners
    Route::delete('partners/destroy', 'PartnerController@massDestroy')->name('partners.massDestroy');
    Route::post('partners/parse-csv-import', 'PartnerController@parseCsvImport')->name('partners.parseCsvImport');
    Route::post('partners/process-csv-import', 'PartnerController@processCsvImport')->name('partners.processCsvImport');
    Route::resource('partners', 'PartnerController');

    // Deposits
    Route::post('deposits/approve', 'DepositController@deposit_approve')->name('deposits.deposit_approve');
    Route::delete('deposits/destroy', 'DepositController@massDestroy')->name('deposits.massDestroy');
    Route::post('deposits/media', 'DepositController@storeMedia')->name('deposits.storeMedia');
    Route::post('deposits/ckmedia', 'DepositController@storeCKEditorImages')->name('deposits.storeCKEditorImages');
    Route::post('deposits/parse-csv-import', 'DepositController@parseCsvImport')->name('deposits.parseCsvImport');
    Route::post('deposits/process-csv-import', 'DepositController@processCsvImport')->name('deposits.processCsvImport');
    Route::resource('deposits', 'DepositController');

    // Payouts
    Route::get('payouts/create_bulk', 'PayoutController@create_bulk')->name('payouts.create_bulk');
    Route::post('payouts/store_bulk', 'PayoutController@store_bulk')->name('payouts.store_bulk');
    Route::post('payouts/approve', 'PayoutController@payout_approve')->name('payouts.payout_approve');
    Route::delete('payouts/destroy', 'PayoutController@massDestroy')->name('payouts.massDestroy');
    Route::post('payouts/media', 'PayoutController@storeMedia')->name('payouts.storeMedia');
    Route::post('payouts/ckmedia', 'PayoutController@storeCKEditorImages')->name('payouts.storeCKEditorImages');
    Route::post('payouts/parse-csv-import', 'PayoutController@parseCsvImport')->name('payouts.parseCsvImport');
    Route::post('payouts/process-csv-import', 'PayoutController@processCsvImport')->name('payouts.processCsvImport');
    Route::resource('payouts', 'PayoutController');


    // Payout Bulks
    Route::delete('payout-bulks/destroy', 'PayoutBulkController@massDestroy')->name('payout-bulks.massDestroy');
    Route::post('payout-bulks/media', 'PayoutBulkController@storeMedia')->name('payout-bulks.storeMedia');
    Route::post('payout-bulks/ckmedia', 'PayoutBulkController@storeCKEditorImages')->name('payout-bulks.storeCKEditorImages');
    Route::post('payout-bulks/parse-csv-import', 'PayoutBulkController@parseCsvImport')->name('payout-bulks.parseCsvImport');
    Route::post('payout-bulks/process-csv-import', 'PayoutBulkController@processCsvImport')->name('payout-bulks.processCsvImport');
    Route::resource('payout-bulks', 'PayoutBulkController');

    // Currencies
    Route::delete('currencies/destroy', 'CurrencyController@massDestroy')->name('currencies.massDestroy');
    Route::post('currencies/parse-csv-import', 'CurrencyController@parseCsvImport')->name('currencies.parseCsvImport');
    Route::post('currencies/process-csv-import', 'CurrencyController@processCsvImport')->name('currencies.processCsvImport');
    Route::resource('currencies', 'CurrencyController');

    // Payout Banks
    Route::delete('payout-banks/destroy', 'PayoutBankController@massDestroy')->name('payout-banks.massDestroy');
    Route::post('payout-banks/parse-csv-import', 'PayoutBankController@parseCsvImport')->name('payout-banks.parseCsvImport');
    Route::post('payout-banks/process-csv-import', 'PayoutBankController@processCsvImport')->name('payout-banks.processCsvImport');
    Route::resource('payout-banks', 'PayoutBankController');

    // Settlements
    Route::post('settlements/approve', 'SettlementController@settlement_approve')->name('settlements.settlement_approve');
    Route::delete('settlements/destroy', 'SettlementController@massDestroy')->name('settlements.massDestroy');
    Route::post('settlements/media', 'SettlementController@storeMedia')->name('settlements.storeMedia');
    Route::post('settlements/ckmedia', 'SettlementController@storeCKEditorImages')->name('settlements.storeCKEditorImages');
    Route::post('settlements/parse-csv-import', 'SettlementController@parseCsvImport')->name('settlements.parseCsvImport');
    Route::post('settlements/process-csv-import', 'SettlementController@processCsvImport')->name('settlements.processCsvImport');
    Route::resource('settlements', 'SettlementController');

    // Settlement Banks
    Route::delete('settlement-banks/destroy', 'SettlementBankController@massDestroy')->name('settlement-banks.massDestroy');
    Route::post('settlement-banks/parse-csv-import', 'SettlementBankController@parseCsvImport')->name('settlement-banks.parseCsvImport');
    Route::post('settlement-banks/process-csv-import', 'SettlementBankController@processCsvImport')->name('settlement-banks.processCsvImport');
    Route::resource('settlement-banks', 'SettlementBankController');

    // Balances
    Route::put('balances/balance_settle', 'BalanceController@balance_settle')->name('balances.balance_settle'); // balance settle
    Route::delete('balances/destroy', 'BalanceController@massDestroy')->name('balances.massDestroy');
    Route::post('balances/parse-csv-import', 'BalanceController@parseCsvImport')->name('balances.parseCsvImport');
    Route::post('balances/process-csv-import', 'BalanceController@processCsvImport')->name('balances.processCsvImport');
    Route::resource('balances', 'BalanceController');

    // Top Ups
    Route::get('reporting/deposit_daily_adjustment', 'TopUpController@deposit_daily_adjustment')->name('reporting.deposit_daily_adjustment');
    Route::post('top-ups/approve', 'TopUpController@topUp_approve')->name('top-ups.topUp_approve');
    Route::delete('top-ups/destroy', 'TopUpController@massDestroy')->name('top-ups.massDestroy');
    Route::post('top-ups/media', 'TopUpController@storeMedia')->name('top-ups.storeMedia');
    Route::post('top-ups/ckmedia', 'TopUpController@storeCKEditorImages')->name('top-ups.storeCKEditorImages');
    Route::post('top-ups/parse-csv-import', 'TopUpController@parseCsvImport')->name('top-ups.parseCsvImport');
    Route::post('top-ups/process-csv-import', 'TopUpController@processCsvImport')->name('top-ups.processCsvImport');
    Route::resource('top-ups', 'TopUpController');

    // Api Keys
    Route::delete('api-keys/destroy', 'ApiKeyController@massDestroy')->name('api-keys.massDestroy');
    Route::post('api-keys/parse-csv-import', 'ApiKeyController@parseCsvImport')->name('api-keys.parseCsvImport');
    Route::post('api-keys/process-csv-import', 'ApiKeyController@processCsvImport')->name('api-keys.processCsvImport');
    Route::resource('api-keys', 'ApiKeyController');

    // Saving Accounts
    Route::get('saving-accounts/get_bank_data', 'SavingAccountController@get_bank_data')->name('saving-accounts.get_bank_data');
    Route::get('saving-accounts/check_bank_balance', 'SavingAccountController@check_bank_balance')->name('saving-accounts.check_bank_balance');
    Route::delete('saving-accounts/destroy', 'SavingAccountController@massDestroy')->name('saving-accounts.massDestroy');
    Route::post('saving-accounts/parse-csv-import', 'SavingAccountController@parseCsvImport')->name('saving-accounts.parseCsvImport');
    Route::post('saving-accounts/process-csv-import', 'SavingAccountController@processCsvImport')->name('saving-accounts.processCsvImport');
    Route::resource('saving-accounts', 'SavingAccountController');

    // Gate Saving Accounts
    Route::get('gate-saving-accounts/get_bank_list', 'GateSavingAccountController@get_bank_list')->name('gate-saving-accounts.get_bank_list');
    Route::delete('gate-saving-accounts/destroy', 'GateSavingAccountController@massDestroy')->name('gate-saving-accounts.massDestroy');
    Route::post('gate-saving-accounts/parse-csv-import', 'GateSavingAccountController@parseCsvImport')->name('gate-saving-accounts.parseCsvImport');
    Route::post('gate-saving-accounts/process-csv-import', 'GateSavingAccountController@processCsvImport')->name('gate-saving-accounts.processCsvImport');
    Route::resource('gate-saving-accounts', 'GateSavingAccountController');

    // Whitelist Ip Addresses
    Route::delete('whitelist-ip-addresses/destroy', 'WhitelistIpAddressController@massDestroy')->name('whitelist-ip-addresses.massDestroy');
    Route::post('whitelist-ip-addresses/parse-csv-import', 'WhitelistIpAddressController@parseCsvImport')->name('whitelist-ip-addresses.parseCsvImport');
    Route::post('whitelist-ip-addresses/process-csv-import', 'WhitelistIpAddressController@processCsvImport')->name('whitelist-ip-addresses.processCsvImport');
    Route::resource('whitelist-ip-addresses', 'WhitelistIpAddressController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Products
    Route::get('products/get_gate_list', 'ProductController@get_gate_list')->name('products.get_bank_list');
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::post('products/parse-csv-import', 'ProductController@parseCsvImport')->name('products.parseCsvImport');
    Route::post('products/process-csv-import', 'ProductController@processCsvImport')->name('products.processCsvImport');
    Route::resource('products', 'ProductController');

    // Whitelist Emails
    Route::delete('whitelist-emails/destroy', 'WhitelistEmailController@massDestroy')->name('whitelist-emails.massDestroy');
    Route::post('whitelist-emails/parse-csv-import', 'WhitelistEmailController@parseCsvImport')->name('whitelist-emails.parseCsvImport');
    Route::post('whitelist-emails/process-csv-import', 'WhitelistEmailController@processCsvImport')->name('whitelist-emails.processCsvImport');
    Route::resource('whitelist-emails', 'WhitelistEmailController');

    // Report
    Route::get('reporting/daily_statement', 'ReportController@daily_statement')->name('reporting.daily_statement');
});
// Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
// // Change password
//     if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
//         Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
//         Route::post('password', 'ChangePasswordController@update')->name('password.update');
//         Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
//         Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
//     }
// });
