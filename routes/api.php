<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DefinitionController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ServiceOwnerController;
use App\Http\Controllers\Api\ServiceScheduleController;
use App\Http\Controllers\Api\AttributeKeyController;
use App\Http\Controllers\Api\ServiceSocialMediaController;
use App\Http\Controllers\Api\ServiceAttachmentController;
use App\Http\Controllers\Api\ServiceAttributesController;
use App\Http\Controllers\Api\ServiceOwnerAttributeController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;


Route::middleware(['set.locale'])->group(function () {
    Route::get('/configs', [DefinitionController::class, 'configs']);
    Route::get('/countries', [DefinitionController::class, 'countries']);
    Route::get('/countries/{id}/governorates', [DefinitionController::class, 'governorates']);
    Route::get('/governorates/{id}/zones', [DefinitionController::class, 'zones']);
    Route::get('/social-media', [DefinitionController::class, 'socialMedia']);
    Route::get('/service-types', [DefinitionController::class, 'serviceTypes']);
    Route::get('/tags', [DefinitionController::class, 'tags']);
    Route::get('tags/{service_type}/service-type', [DefinitionController::class, 'getTagByServiceType']);

    Route::get('/academic-qualifications', [DefinitionController::class, 'academicQualifications']);

    Route::post('login', [AuthController::class, 'login']);
});



Route::middleware(['set.locale', 'auth.custom'])->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::middleware(['user.type:dataEntry'])->group(function () {
        Route::resource('service-owners', ServiceOwnerController::class)->only('store', 'update', 'index','show');
        Route::get('all-service-owners', [ServiceOwnerController::class, 'getAllServiceOwners']);
        Route::resource('services', ServiceController::class);
        Route::get('services-all', [ServiceController::class, 'getAllServices']);

        Route::post('/services/{serviceId}/schedules/save', [ServiceScheduleController::class, 'save']);
        Route::post('/services/{serviceId}/social/save', [ServiceSocialMediaController::class, 'save']);

        Route::resource('attribute-key', AttributeKeyController::class);

        Route::post('/services/{serviceId}/service-attachments/save', [ServiceAttachmentController::class, 'store']);
        Route::get('/services/{serviceId}/service-attachments/getAll', [ServiceAttachmentController::class, 'getServiceAttachments']);
        Route::get('/services/service-attachments/{id}', [ServiceAttachmentController::class, 'show']);
        Route::delete('/services/service-attachments/{id}', [ServiceAttachmentController::class, 'delete']);
        Route::put('/services/service-attachments/{id}', [ServiceAttachmentController::class, 'update']);

        Route::post('/services/{serviceId}/attributeKey/save', [ServiceAttributesController::class, 'save']);
        Route::post('/serviceOWner/{serviceOwnerId}/attributeKey/save', [ServiceOwnerAttributeController::class, 'save']);

        Route::resource('tags', TagController::class)->only('store');
    });
});
