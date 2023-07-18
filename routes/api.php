<?php

use App\Http\Controllers\admin\AuthController;
use App\Http\Controllers\admin\PermissionController;
use App\Http\Controllers\admin\RoleController;
use App\Http\Controllers\admin\TeacherController;
use App\Http\Controllers\api\ApplicationController;
use App\Http\Controllers\api\AuthController as ApiAuthController;
use App\Http\Controllers\api\ChatController;
use App\Http\Controllers\admin\BlacklistController;
use App\Http\Controllers\api\ChildMaterialController;
use App\Http\Controllers\api\CustomerController;
use App\Http\Controllers\api\DeviceController;
use App\Http\Controllers\api\DocumentController;
use App\Http\Controllers\api\GroupController;
use App\Http\Controllers\admin\AdminSettingController;
use App\Http\Controllers\api\MaterialController;
use App\Http\Controllers\api\OfferController;
use App\Http\Controllers\api\SubMaterialController;
use App\Http\Controllers\api\TeacherAvailabilityController;
use App\Http\Controllers\api\TeacherChildMaterialController;
use App\Http\Controllers\api\SettingController;
use App\Http\Controllers\api\TeacherController as ApiTeacherController;
use App\Http\Controllers\api\TeacherMaterialController;
use App\Http\Controllers\api\TeacherReportController;
use App\Http\Controllers\api\TeacherSubMaterialController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProvinceController;
use Illuminate\Support\Facades\Route;

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

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/login/phone', [UserController::class, 'phoneLogin']);
Route::post('google_login', [ApiAuthController::class, 'login_google']);
Route::post('facebook_login', [ApiAuthController::class, 'login_facebook']);
Route::post('linkedin_login', [ApiAuthController::class, 'login_linkedin']);
Route::post('apple_login', [ApiAuthController::class, 'apple_login']);
Route::post('reset_password', PasswordResetController::class);
Route::post('reset_password/check', [PasswordResetController::class, 'check']);
Route::post('reset_password/reset', [PasswordResetController::class, 'reset']);
Route::get('countries', CountryController::class);
Route::get('province', ProvinceController::class);
Route::get('materials', MaterialController::class);
Route::get('sub_materials', SubMaterialController::class);
Route::get('child_materials', ChildMaterialController::class);
Route::get('subjects_list', [\App\Http\Controllers\api\TeacherController::class, 'get_subject_list']);
Route::middleware('auth:api')->group(function () {
    Route::post('/teachers', [ApiTeacherController::class, 'register']);
    Route::get('/teachers', [ApiTeacherController::class, 'profile']);
    Route::put('/teachers', [ApiTeacherController::class, 'update']);
    Route::post('/teachers/upload_file', [ApiTeacherController::class, 'upload_document']);
    Route::delete('/teachers/upload_file/delete/{file}', [ApiTeacherController::class, 'delete_document']);
    Route::get('/get_teacher_applications', [ApplicationController::class, 'teacher_applications']);
    Route::apiResource('/customer', CustomerController::class);
    Route::post('/customer/update_image/{customer}', [CustomerController::class, 'update_image']);
    Route::get('/teacher/available_times', [TeacherAvailabilityController::class, 'getAvailableTimes']);
    Route::post('/teacher/get_by_map', [TeacherAvailabilityController::class, 'getMapTeachers']);
    Route::get('/teacher/show_available_time/{id}', [TeacherAvailabilityController::class, 'showAvailableTime']);
    Route::post('/teacher/editAvailableTime/{id}', [TeacherAvailabilityController::class, 'editAvailableTime']);
    Route::post('/teacher/getDaysBetweenTwoDates', [TeacherAvailabilityController::class, 'getDaysBetweenTwoDates']);
    Route::post('devices/save_token', [DeviceController::class, 'saveDeviceToken'])->name('devices.save_token');
    Route::post('devices/delete_token', [DeviceController::class, 'deleteDeviceToken'])->name('devices.delete_token');
    Route::get('settings/get_all',[SettingController::class,'showMyNotificationSettings']);
    Route::post('settings/update_settings',[SettingController::class,'updateNotificationSettings']);
    Route::post('contact_us/send',[\App\Http\Controllers\ContactUsController::class,'send']);
    Route::get('contact_us',[\App\Http\Controllers\ContactUsController::class,'index']);
    Route::get('contact_us/{contactUs}',[\App\Http\Controllers\ContactUsController::class,'show']);
});
Route::group(['middleware' => ['auth:api', 'checkRole'], 'roles' => ['Customer', 'Teacher', 'Admin']], function () {
    Route::apiResource('/offer', OfferController::class);
    Route::post('/check_application', [OfferController::class, 'check_application']);
    Route::get('/offer/applications/{id}', [OfferController::class, 'get_offer_applications']);
    Route::post('/chats', [ChatController::class, 'createChat']);
    Route::get('/chats', [ChatController::class, 'index']);
    Route::get('/chats/{id}', [ChatController::class, 'show']);
    Route::post('/chats/send', [ChatController::class, 'sendMessage']);
    Route::get('/chats/messages/{id}', [ChatController::class, 'messages']);

    Route::post('user/updateImage', [UserController::class, 'update']);
    Route::apiResource('docs', DocumentController::class);

    Route::get('teacher/materials', [TeacherMaterialController::class, 'index']);

    Route::get('/teacher/sub_materials', [TeacherSubMaterialController::class, 'index']);
    Route::get('/teacher/child_materials', [TeacherChildMaterialController::class, 'index']);
    Route::get('/teacher/all_materias_details',[ApiTeacherController::class,'all_materias_details']);
    Route::apiResource('/reports', TeacherReportController::class);

    Route::post('application_status', [ApplicationController::class, 'application_status']);
});
Route::group(['middleware' => ['auth:api', 'checkRole'], 'roles' => ['Teacher']], function () {
    Route::apiResource('/application', ApplicationController::class);
    Route::get('/teacher/get_applications', [ApiTeacherController::class, 'get_teacher_applications']);
    Route::post('/teacher/materials', [TeacherMaterialController::class, 'create']);
    Route::post('/teacher/sub_materials', [TeacherSubMaterialController::class, 'create']);
    Route::post('/teacher/child_materials', [TeacherChildMaterialController::class, 'create']);
    Route::post('/teacher/child_materials/{id}', [TeacherChildMaterialController::class, 'destroy']);
    Route::delete('/teacher/sub_materials/{id}', [TeacherSubMaterialController::class, 'destroy']);
    Route::delete('/teacher/materials/{id}', [TeacherMaterialController::class, 'destroy']);
    Route::post('/teacher/available_days', [TeacherAvailabilityController::class, 'store']);
});
Route::group(['middleware' => ['auth:api', 'checkRole'], 'roles' => ['Admin']], function () {
    Route::get('/get_teacher_applications', [ApplicationController::class, 'teacher_applications']);
});
Route::prefix('admin')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login_remember', [AuthController::class, 'remember_login']);
    Route::middleware('auth:api')->group(function () {
        Route::post('teacher/create',[TeacherController::class,'store']);
        Route::post('teacher/update_verify/{teacher}',[TeacherController::class,'update_verify']);
        Route::put('teacher/{teacher}',[TeacherController::class,'update']);
        Route::delete('teacher/{teacher}',[TeacherController::class,'destroy']);
        Route::apiResource('blacklist',BlacklistController::class);
        Route::get('/teachers', [TeacherController::class, 'index']);
        Route::get('/teachers/{id}', [TeacherController::class, 'show']);
        Route::apiResource('roles', RoleController::class);
        Route::get('/get_role_permissions', [\App\Http\Controllers\api\RoleController::class, 'get_role_permissions']);
        Route::get('permissions', PermissionController::class);
        Route::get('settings',[AdminSettingController::class,'index']);
        Route::post('settings',[AdminSettingController::class,'store']);
        Route::apiResource('offers', \App\Http\Controllers\admin\OfferController::class);
        Route::get('/offers/applications/{id}', [\App\Http\Controllers\admin\OfferController::class, 'get_offer_applications']);
        Route::post('/offers/check_application', [\App\Http\Controllers\admin\OfferController::class, 'check_application']);
        Route::post('/offers/applications_by_status', [\App\Http\Controllers\admin\OfferController::class, 'get_application_by_status']);
    });
});

//Group routes
Route::group(['middleware' => 'auth:api'], function () {
    Route::post('groups', [GroupController::class, 'store']);
    Route::get('groups', [GroupController::class, 'index']);
    Route::get('groups/{group}', [GroupController::class, 'show']);
    Route::put('groups/{group}', [GroupController::class, 'update']);
    Route::delete('groups/{group}', [GroupController::class, 'destroy']);
    Route::post('groups/add_users', [GroupController::class, 'addUsersToGroup'])->name('groups.add_users');
    Route::post('groups/delete_users', [GroupController::class, 'deleteUsersFromGroups'])
        ->name('groups.delete_users');
    Route::get('groups/show/get_users', [GroupController::class, 'getUserOfGroup'])->name('groups.get_users');
    Route::post('groups/send_message', [GroupController::class, 'sendMessage'])->name('groups.send_message');
    Route::get('groups/show/get_messages', [GroupController::class, 'getMessages'])->name('groups.get_messages');
    Route::get('groups/get/my_contact', [GroupController::class, 'getMyContact'])->name('groups.my_contact');
    Route::get('groups/get/my_groups', [GroupController::class, 'getMyGroups'])->name('groups.my_groups');
    Route::get('groups/get/search', [GroupController::class, 'search'])->name('groups.search');
});
