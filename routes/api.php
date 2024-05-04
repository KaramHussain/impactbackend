<?php

use Illuminate\Support\Facades\Route;

Route::post('test', 'ediApisController@send_http_request');
Route::post('test-graphs', 'ediApisController@send_http_request_for_graphs');

//edi services
Route::post('/get_graph', 'ediApisController@get_graph');
Route::get('/get_graph-test', 'ediApisController@get_graph');
Route::post('/get_upload_details', 'ediApisController@get_upload_details');
Route::post('/get_remark', 'ediApisController@get_remark');
Route::post('/get_payers', 'ediApisController@get_payer');
Route::post('/get_file_details', 'ediApisController@get_file_details');
Route::post('/get_rc_ins', 'ediApisController@get_rc_inc');
Route::post('/eob_load', 'ediApisController@eob_upload');
Route::post('/submit_edi', 'ediApisController@submit_edi');
Route::post('/get_claim837', 'ediApisController@get_claim837');

Route::prefix('/auth/insurance')->middleware(['auth:api'])->group(function () {
    Route::post('create', 'insurance\insuranceController@create');
    Route::post('getAll', 'insurance\insuranceController@getAuthInsurances');
    Route::post('{insurance}', 'insurance\insuranceController@getAuthInsurance');
    Route::post('{id}/update', 'insurance\insuranceController@update');
    Route::post('{id}/delete', 'insurance\insuranceController@delete');
});

//////////***********Auth insurance dependants links*************//////////////

Route::middleware(['auth:api'])->prefix('/auth/dependants')->group(function () {
    Route::post('all', 'dependants\dependantsController@index');
    Route::post('create', 'dependants\dependantsController@store');
    Route::post('update/{dependant}', 'dependants\dependantsController@update');
    Route::post('delete/{dependant}', 'dependants\dependantsController@delete');
});

//////////***********Provider links*************//////////////

Route::prefix('provider')->middleware('guest')->group(function () {
    Route::post('login', 'providers\loginController@login');
    Route::post('register', 'providers\registerController@register');
    Route::get('get_provider_info', 'providers\registerController@get_provider_details_by_npi');
    Route::get('activate', 'providers\activationController@activate');
    Route::get('resend-activation-link', 'providers\resendActivationLinkController@resend');
    Route::get('forgot-password', 'providers\forgotPasswordController@sendResetPasswordLink');
    Route::get('reset-password', 'providers\forgotPasswordController@resetPassword');
    Route::get('check-if-reset-token-exists', 'providers\forgotPasswordController@checkIfResetTokenExists');
    Route::post('/notify-claim-uploaded', 'providers\notifications\providerNotificationsController@send_claim_uploaded_notification');
    Route::post('/save-claims', 'providers\providerClaimsController@store');
    // Route::get('get-remark-codes-with-dates', 'providers\reportsController@get_remark_codes_with_dates');
    // Route::get('get-claims-with-collector', 'providers\reportsController@get_claims_with_assoc_collectors')
    Route::get('test-history', 'providers\claimHistoryController@index');
    Route::post('get-claims-with-collector', 'providers\reportsController@get_claims_with_assoc_collectors'); //this route will be removed from here to auth group below 

});


Route::prefix('provider')->middleware(['auth:providers'])->group(function () {
    Route::get('me', 'providers\meController@me');
    Route::get('all', 'providers\providersController@index');
    Route::get('permissions', 'providers\providersController@permissions');
    Route::get('role-permissions', 'providers\providersController@rolePermissions');
    Route::post('logout', 'providers\logoutController@logout');
    Route::post('change-password', 'providers\passwordsController@update');
    Route::post('change-account', 'providers\changeAccountController@update');
    Route::post('change-company-details', 'providers\practises\practiseController@update');
    Route::post('update-image', 'providers\imagesController@update');
    Route::post('delete-image', 'providers\imagesController@destroy');
    Route::post('add-member', 'providers\members\membersController@store');
    Route::post('fetch-member/{member}', 'providers\members\membersController@show');
    Route::post('update-member/{member}', 'providers\members\membersController@update');
    Route::post('delete-member/{member}', 'providers\members\membersController@destroy');
    Route::get('/notifications', 'providers\notifications\providerNotificationsController@showAllunread');
    Route::get('/notifications-mark-read', 'providers\notifications\providerNotificationsController@markAsRead');
    Route::get('/notifications/all', 'providers\notifications\providerNotificationsController@index');
    Route::get('/notification-by-id', 'providers\notifications\providerNotificationsController@show');
    Route::post('/assign-claim', 'providers\providerClaimsController@assign_claim');
    Route::post('/check-claim-status', 'providers\providerClaimsController@check_claim_status');
    Route::post('/claims', 'providers\providerClaimsController@index');
    Route::post('/get-collector-claims', 'providers\providerClaimsController@get_working_claims_of_collector');
    Route::post('/update-claim', 'providers\providerClaimsController@update');
    // Route::post('get-claims-with-collector', 'providers\reportsController@get_claims_with_assoc_collectors');
    Route::post('get-remark-codes-with-dates', 'providers\reportsController@get_remark_codes_with_dates');
    Route::post('get-collector-stats-reports', 'providers\reportsController@get_stats_with_collectors');

    Route::prefix('claim/notes')->group(function () {
        Route::post('store', 'providers\claimNotesController@store');
        Route::post('{note}/update', 'providers\claimNotesController@update');
        Route::post('{note}/destroy', 'providers\claimNotesController@destroy');
        Route::post('{id}', 'providers\claimNotesController@index');
    });

    Route::prefix('claim/revisions')->group(function () {
        Route::post('store', 'providers\claimRevisionsController@store');
        Route::post('all', 'providers\claimRevisionsController@index');
    });

    Route::post('{provider}', 'providers\providersController@show'); //must remain at end

});

Route::get('/fetch-suggestions', 'providers\suggestionsController@fetch');
Route::get('payer-list', 'payersController');

//////////***********Auth links*************//////////////
Route::post('/auth/register', 'auth\RegisterController@register');
Route::post('/auth/login', 'auth\LoginController@login');
Route::post('/auth/logout', 'auth\LogoutController@logout');
Route::post('/auth/update', 'auth\meController@update');
Route::post('/auth/update/basic-info', 'auth\profile\basicsController@update');
Route::post('/auth/update/address', 'auth\profile\addressController@update');
Route::post('/auth/update/security/password', 'auth\profile\security\passwordChangeController@update');
Route::post('/auth/update/security/email', 'auth\profile\security\emailChangeController@update');
Route::post('/auth/update/security/questions', 'auth\profile\security\questionsController@update');
Route::post('/auth/update/image', 'auth\profile\imagesController@update');
Route::post('/auth/delete/image', 'auth\profile\imagesController@destroy');
Route::get('/auth/activate', 'auth\activationController@activate');
Route::get('/auth/resendActivationLink', 'auth\resendActivationController@resend');
Route::get('/me', 'auth\meController@me'); //profile
Route::get('/forgotPassword', 'auth\ForgotPasswordController@sendResetPasswordLink');
Route::get('/resetPassword', 'auth\ForgotPasswordController@resetPassword');
Route::get('/checkIfResetTokenExists', 'auth\ForgotPasswordController@checkIfResetTokenExists');

// per hour rate limit for authenticated and unauthenticated users
// 10 requests per hour for authenticated user (20 means 10, somehow it's counting one request twice)
Route::middleware('throttle:10000,1')->group(function () {

    //////**************Auth links ends***********/////////
    Route::get('/getTreatmentsExtract', 'layterms\laytermsController@treatmentExtract');

    ////////////////////////Preventive Care///////////////////////
    Route::get('/preventive-care/step/{step}', 'preventiveCareController\preventiveCareController@save_a_life_step');

    //////////////////////////////////////////Anatomy/////////////////////
    Route::get('parts-all', 'AnatomyController\partsAndGenderController@index')->name('parts.index');
    Route::get('hpi-parts-all', 'AnatomyController\partsAndGenderController@fetch_hpi_parts')->name('parts.fetch-hpi-parts');
    Route::get('/fetch-symptoms', 'AnatomyController\symptomsController@fetchSymptoms')->name('fetch-symptoms');
    Route::get('/fetch-questions', 'AnatomyController\questionsController@fetch')->name('anatomy-fetch-questions');
    Route::get('/fetch-diseases', 'AnatomyController\diseasesController@fetchDiseases');
    Route::get('anatomy/ages', 'AnatomyController\partsAndGenderController@getAges');
    Route::get('anatomy/fetch-parts', 'AnatomyController\partsAndGenderController@getParts');
    Route::get('/anatomy/cpt_layterms', 'AnatomyController\symptomsController@selectLaytermsOfCpt');
    Route::get("/anatomy/fetch-symptoms-from-subparts", 'AnatomyController\symptomsController@fetchSymptomsFromParts');
    Route::get('/fetchTreatmentName', 'AnatomyController\symptomsController@fetchTreatmentName');
    Route::get('/getSymptomsInAllParts', 'AnatomyController\symptomsController@fetchSymptomsInAllParts');
    Route::get('/searchCptsFromDiseases', 'AnatomyController\symptomsController@searchCptsFromDiseases');
    Route::get('/getCptsFromIcd', 'AnatomyController\diseasesController@getCptsFromIcd');

    ///////////////*******Search Engine********///////////////////
    Route::get("/search", 'search\searchController@search');
    Route::get('/filter-search-term', 'search\filterSearchController@filter_search');
    Route::get('/get-code-terms', 'search\searchController@get_codes_terms');
    Route::get("/fetchPayerNames", "insurance\insuranceController@fetch");
    Route::get("/fetchTypes", "insurance\insuranceController@types");
    Route::get("/searchSubmit", 'search\searchController@search_submit');
    Route::get('/getChildrenOfRootChild', 'search\searchController@getChildrenOfRootChild');
    Route::get('/searchAndFetchCpts', 'search\searchController@searchAndFetchCpts');
    Route::get('/searchAndFetchCptLayterms', 'search\searchController@searchAndFetchCptLayterms');
    Route::get('/fetch-categories', 'search\treatment\categoryController@index');
    Route::get('/search-categories-for-selected-term', 'search\treatment\categoryController@search_categories_for_selected_term');
    Route::get('/fetchCodeDescription', 'shoppingWindowController@getDescriptionOfCptCode');
    Route::get('/fetch-provider-types', 'shoppingWindowController@fetch_provider_types');
    Route::get('/fetchSubCategories', 'layterms\laytermsController@fetchSubCategoriesFromCodes');
    Route::get('/fetch-treatments-from-category-and-bodypart', 'search\treatment\childrenController@fetch_terms_from_category_and_bodypart');
    Route::get('/find-treatment-and-set-codes', 'search\treatment\childrenController@find_treatment_and_set_codes');

    ///////////////////*******Shopping window*********//////////////////
    Route::get('/fetchTreatments', 'shoppingWindowController@fetch');
    Route::get('/fetchTreatmentsWithDistance', 'shoppingWindowController@fetchWithDistance');
    Route::get('getDoctorCreds', 'shoppingWindowController@fetchCreds');
    Route::post('auth/sendOffer', 'shoppingWindowController@sendEmailToUser');

    ///////////////////*******Rules Code Ranges*******//////////////////
    Route::get('fetchPartRanges', 'rules\rangesController@index');
    Route::get('fetch-code-ranges', 'rules\rangesController@fetch_code_ranges');

    //////////////////////*******Cities and states*******////////////////////
    Route::get("/getCities", "citiesController@index");
    Route::get("/getStates", "statesController@index");
    Route::get("/languages", "languagesController@index");

    Route::get('get-master-directory-specialities', 'masterDirectoryController@fetch_specialaites');
    Route::get('get-master-directory-sub-specialities', 'masterDirectoryController@fetch_sub_specialaites');
    Route::get('get-doctors-in-master-directory', 'masterDirectoryController@fetch_doctors');


});

///////////////////*******Cart and checkout*******//////////////////
Route::post('/add-to-cart', 'cartController@store');
Route::post('/get-cart', 'cartController@index');
Route::post('/cart/total', 'cartController@getCount');
Route::post('cart/{id}/delete', 'cartController@destroy');
Route::post('update-cart-evob-charges', 'cartController@update_cart_details');
Route::post('update-cart-charges', 'cartController@update_cart_charges');
Route::post('/auth/cart/checkout', 'checkoutController@create');

///////////////////////*******Reports*******////////////////////
Route::get('/reports/invoices/all', 'admin\reportsController@getCheckoutReport');
Route::get('/reports/invoices/{invoice}', 'admin\reportsController@invoiceReport');

////////////////////*********PaymentMethods*********////////////////////////
Route::resource('payment-methods', 'payments\paymentMethodsController');

////////////////////*********Notifications*********////////////////////////
Route::get('/subscribe', 'notifications\subscriptionsController@subscribe');

//////////////////**********Claims*********** //////////////////////////
Route::post('/claim/create', 'claims\claimsController@store');
Route::post('/auth/claim', 'claims\claimsController@show');
Route::get('/get-pos-tos', 'posTosController');

//////////////////**********Eobs All*********** //////////////////////////
Route::post('/auth/eob/{claim}', 'auth\profile\eobsController@show');
Route::post('auth/eobs/all', 'auth\profile\eobsController@index');

///////////////////////*******Orders*******////////////////////
Route::post('/orders', 'OrdersController@index');
Route::post('/orders/{id}', 'OrdersController@show');
Route::post('/order/complete/{order}', 'OrdersController@complete');

///////////////////////*******Support*******////////////////////
Route::post('/support-email', 'Support\SupportController@sendSupportEmail');
