<?php

use Illuminate\Support\Facades\Route;

use App\Modules\ECOMMERCE\Managements\Configurations\Controllers\StorageController;
use App\Modules\ECOMMERCE\Managements\Configurations\Controllers\SystemController;


use App\Modules\ECOMMERCE\Managements\Configurations\Controllers\ConfigController;

/*
|--------------------------------------------------------------------------
| Configuration Management Routes
|--------------------------------------------------------------------------
| Here is where you can register web routes for configuration management in the ECOMMERCE module. These
|
*/

// config setup
Route::get('config/setup', [ConfigController::class, 'configSetup'])->name('ConfigSetup');
Route::post('update/config/setup', [ConfigController::class, 'updateConfigSetup'])->name('UpdateConfigSetup');

// config routes for sim
Route::get('/view/all/sims', [ConfigController::class, 'viewAllSims'])->name('ViewAllSims');
Route::get('/delete/sim/{id}', [ConfigController::class, 'deleteSim'])->name('DeleteSim');
Route::get('/get/sim/info/{id}', [ConfigController::class, 'getSimInfo'])->name('GetSimInfo');
Route::post('/update/sim', [ConfigController::class, 'updateSimInfo'])->name('UpdateSimInfo');
Route::post('/create/new/sim', [ConfigController::class, 'createNewSim'])->name('CreateNewSim');


// config routes for device condition
Route::post('/create/new/device/condition', [ConfigController::class, 'addNewDeviceCondition'])->name('AddNewDeviceCondition');
Route::get('/view/all/device/conditions', [ConfigController::class, 'viewAllDeviceConditions'])->name('ViewAllDeviceConditions');
Route::get('/delete/device/condition/{id}', [ConfigController::class, 'deleteDeviceCondition'])->name('DeleteDeviceCondition');
Route::get('/get/device/condition/info/{id}', [ConfigController::class, 'getDeviceConditionInfo'])->name('GetDeviceConditionInfo');
Route::post('/update/device/condition', [ConfigController::class, 'updateDeviceCondition'])->name('UpdateDeviceCondition');
Route::get('/rearrange/device/condition', [ConfigController::class, 'rearrangeDeviceCondition'])->name('RearrangeDeviceCondition');
Route::post('/save/rearranged/device/condition', [ConfigController::class, 'saveRearrangeDeviceCondition'])->name('SaveRearrangeDeviceCondition');


// config for product warrenty
Route::post('/create/new/warrenty', [ConfigController::class, 'addNewProductWarrenty'])->name('AddNewProductWarrenty');
Route::get('//view/all/warrenties', [ConfigController::class, 'viewAllProductWarrenties'])->name('ViewAllProductWarrenties');
Route::get('/delete/warrenty/{id}', [ConfigController::class, 'deleteProductWarrenty'])->name('DeleteProductWarrenty');
Route::get('/get/warrenty/info/{id}', [ConfigController::class, 'getProductWarrentyInfo'])->name('GetProductWarrentyInfo');
Route::post('/update/warrenty', [ConfigController::class, 'updateProductWarrenty'])->name('UpdateProductWarrenty');
Route::get('/rearrange/warrenty', [ConfigController::class, 'rearrangeWarrenty'])->name('RearrangeWarrenty');
Route::post('/save/rearranged/warrenty', [ConfigController::class, 'saveRearrangeWarrenties'])->name('SaveRearrangeWarrenties');


// storage
Route::post('/create/new/storage', [StorageController::class, 'addNewStorage'])->name('AddNewStorage');
Route::get('/view/all/storages', [StorageController::class, 'viewAllStorages'])->name('ViewAllStorages');
Route::get('/delete/storage/{id}', [StorageController::class, 'deleteStorage'])->name('DeleteStorage');
Route::get('/get/storage/info/{id}', [StorageController::class, 'getStorageInfo'])->name('GetStorageInfo');
Route::post('/update/storage', [StorageController::class, 'updateStorage'])->name('UpdateStorage');
Route::get('/rearrange/storage/types', [StorageController::class, 'rearrangeStorage'])->name('RearrangeStorage');
Route::post('/save/rearranged/storages', [StorageController::class, 'saveRearrangeStorage'])->name('SaveRearrangeStorage');
// payment gateway routes
Route::get('/setup/payment/gateways', [ConfigController::class, 'viewPaymentGateways'])->name('ViewPaymentGateways');
Route::post('/update/payment/gateway/info', [ConfigController::class, 'updatePaymentGatewayInfo'])->name('UpdatePaymentGatewayInfo');
Route::get('/change/payment/gateway/status/{provider}', [ConfigController::class, 'changePaymentGatewayStatus'])->name('ChangePaymentGatewayStatus');
// system routes for email config
Route::get('/view/email/credential', [SystemController::class, 'viewEmailCredentials'])->name('ViewEmailCredentials');
Route::get('/view/email/templates', [SystemController::class, 'viewEmailTemplates'])->name('ViewEmailTemplates');
Route::get('/change/mail/template/status/{templateId}', [SystemController::class, 'changeMailTemplateStatus'])->name('ChangeMailTemplateStatus');
Route::post('/save/new/email/configure', [SystemController::class, 'saveEmailCredential'])->name('SaveEmailCredential');
Route::get('/delete/email/config/{slug}', [SystemController::class, 'deleteEmailCredential'])->name('DeleteEmailCredential');
Route::get('/get/email/config/info/{slug}', [SystemController::class, 'getEmailCredentialInfo'])->name('GetEmailCredentialInfo');
Route::post('/update/email/config', [SystemController::class, 'updateEmailCredentialInfo'])->name('UpdateEmailCredentialInfo');
// system route for sms gateway
Route::get('/setup/sms/gateways', [SystemController::class, 'viewSmsGateways'])->name('ViewSmsGateways');
Route::post('/update/sms/gateway/info', [SystemController::class, 'updateSmsGatewayInfo'])->name('UpdateSmsGatewayInfo');
Route::get('/change/gateway/status/{provider}', [SystemController::class, 'changeGatewayStatus'])->name('ChangeGatewayStatus');
// system route for payment gateway
