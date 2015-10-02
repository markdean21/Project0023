<?php

// PLACE NON PROTECTED ROUTES HERE -- START
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@home');
Route::get('/howitworks', 'HomeController@howitworks');
Route::get('/whychooseproveek', 'HomeController@whychooseproveek');
Route::get('/pricing', 'HomeController@pricing');
Route::get('/login', 'HomeController@login');
Route::post('/doLogin', 'HomeController@doLogin');
Route::get('/register', 'HomeController@register');
Route::post('/doRegisterIndi', 'HomeController@doRegisterIndi');
Route::post('/doRegisterComp', 'HomeController@doRegisterComp');
Route::post('/doRegisterTaskminator', 'HomeController@doRegisterTaskminator');
Route::get('/chainRegion', 'HomeController@chainRegion');
Route::get('/chainCity', 'HomeController@chainCity');
Route::get('/chainProvince', 'HomeController@chainProvince');
Route::get('/regTaskminator', 'HomeController@regTaskminator');
Route::get('/regClientIndi', 'HomeController@regClientIndi');
Route::get('/regClientComp', 'HomeController@regClientComp');
Route::get('/logout', 'HomeController@logout');
Route::get('/changePassword', 'HomeController@changePassword');
Route::post('/forgotPassword', 'HomeController@changePassword');
Route::post('/changePassword', 'HomeController@changePassword');
Route::get('/activateChangePass/{confirmationCode}', 'HomeController@activateChangePass');
Route::get('/activateResetPass/{confirmationCode}', 'HomeController@activateResetPass');
Route::post('/confirmReset', 'HomeController@confirmReset');
Route::post('/confirmChange', 'HomeController@confirmChange');
Route::post('/chainCategoryItems', 'HomeController@chainCategoryItems');
Route::get('/profile/{id}', 'HomeController@profile');

// CHIKKA SMS ROUTES -- START
Route::post('/taskminator/receive', 'SMSAPIController@receive'); //register  http://yourserver.com/yourapp/receive  on the message receiver on API dashboard
Route::post('/taskminator/notify', 'SMSAPIController@notify'); //http://yourserver.com/yourapp/notify for the delivery notification
// CHIKKA SMS ROUTES -- END

// PLACE NON PROTECTED ROUTES HERE -- END

Route::group(array('before' => 'auth'), function(){
    Route::get('/editProfile', 'HomeController@editProfile');
    Route::post('/uploadProfilePic', 'HomeController@uploadProfilePic');
    Route::get('/getNotification', 'HomeController@getNotification');
    Route::get('/showAllNotif', 'HomeController@showAllNotif');
    Route::get('/messages', 'HomeController@messages');
    Route::get('/getMessages/{threadcode}', 'HomeController@getMessages');
    Route::post('/sendMsg', 'HomeController@sendMsg');
    Route::get('/checkMsgs={threadcode}', 'HomeController@checkMsgs');
    Route::get('/checkMsgThread={threadcode}', 'HomeController@checkMsgThread');
    Route::get('/checkMsgCount', 'HomeController@checkMsgCount');
});

Route::group(array('before' => 'ADMIN-ONLY'), function(){
    // THE ROLE BASED ROUTES FOR ADMINISTRATORS GOES HERE
    Route::get('/admin', 'AdminController@index');
    Route::get('/userList', 'AdminController@userList');
    Route::get('/userListTaskminators', 'AdminController@userListTaskminators');
    Route::get('/userListClientIndi', 'AdminController@userListClientIndi');
    Route::get('/userListClientComp', 'AdminController@userListClientComp');
    Route::get('/adminActivate/{id}', 'AdminController@adminActivate');
    Route::get('/viewUserProfile/{id}', 'AdminController@viewUserProfile');

    Route::get('/pendingTskmntr', 'AdminController@pendingTskmntr');
    Route::get('/pendingClientIndi', 'AdminController@pendingClientIndi');
    Route::get('/pendingClientComp', 'AdminController@pendingClientComp');
    Route::get('/pendingTskmntr=search={searchBy}={searchWord}', 'AdminController@pendingTskmntrSearch');
    Route::get('/pendingClientIndi=search={searchBy}={searchWord}', 'AdminController@pendingClientIndiSearch');
    Route::get('/pendingClientComp=search={searchBy}={searchWord}', 'AdminController@pendingClientCompSearch');

    Route::get('/categoryAndSkills', 'AdminController@categoryAndSkills');
    Route::get('/adminDeactivate/{id}', 'AdminController@adminDeactivate');
    Route::get('/AT_{role}', 'AdminController@auditTrail');
    Route::get('/userAuditTrail_{id}', 'AdminController@userAuditTrail');
    Route::get('/admin/taskDetails/{taskid}', 'AdminController@taskDetails');
    Route::get('/viewRatings={tskmntrId}', 'AdminController@viewRatings');
    Route::get('/taskListBidding', 'AdminController@taskListBidding');
    Route::get('/taskListBidding=search={searchBy}={searchWord}={workTimeValue}={status}', 'AdminController@taskListBiddingSearch');
    Route::get('/taskListAuto', 'AdminController@taskListAuto');
    Route::get('/taskListAuto=search={searchBy}={searchWord}={workTimeValue}={status}', 'AdminController@taskListAutoSearch');
    Route::get('/taskListDirect', 'AdminController@taskListDirect');
    Route::get('/taskListDirect=search={searchBy}={searchWord}={workTimeValue}={status}', 'AdminController@taskListDirectSearch');
    Route::post('/userListTaskminators=search', 'AdminController@adminTskmntrSearch');
    Route::post('/userListClientIndi=search', 'AdminController@adminClientIndiSearch');
    Route::post('/userListClientComp=search', 'AdminController@adminClientCompSearch');
    Route::post('/pendingTskmntr=search', 'AdminController@pendingTskmntrsSearch');
    Route::post('/pendingClientIndi=search', 'AdminController@pendingClientIndiSearch');
    Route::post('/pendingClientComp=search', 'AdminController@pendingClientCompSearch');
//    Route::post('/taskListBidding=search', 'AdminController@taskListBiddingSearch');
//    Route::post('/taskListAuto=search', 'AdminController@taskListAutoSearch');
    Route::post('/taskListDirect=search', 'AdminController@taskListDirectSearch');
    Route::get('/viewUsersTasks/{clientid}', 'AdminController@viewUsersTasks');
    Route::post('/viewUsersTasks=search', 'AdminController@viewUsersTasksSearch');
    Route::get('/userListTaskminators=search={searchBy}={searchWord}', 'AdminController@userListTaskminatorsSearch');
    Route::get('/userListClientIndi=search={searchBy}={searchWord}', 'AdminController@userListClientIndiSearch');
    Route::get('/userListClientComp=search={searchBy}={searchWord}', 'AdminController@userListClientCompSearch');
    Route::post('/newSkill', 'AdminController@newSkill');
    Route::post('/newCategory', 'AdminController@newCategory');
    Route::get('/deleteCategory={categorycode}', 'AdminController@deleteCategory');
    Route::get('/deleteSkill={skillcode}', 'AdminController@deleteSkill');
});

Route::group(array('before' => 'TASKMINATOR-ONLY'), function(){
    // THE ROLE BASED ROUTES FOR TASKMINATORS GOES HERE
    Route::get('/tskmntr/taskSearch', 'TaskminatorController@taskSearch');

//    Route::post('/tskmntr/doTaskSearch', 'TaskminatorController@doTaskSearch');
    Route::get('/tskmntr/doTaskSearch={workingTime}={searchField}={searchCity}={searchWord}={rateRange}={rangeValue}', 'TaskminatorController@doTaskSearch');

    Route::get('/tskmntr/currentTask', 'TaskminatorController@currentTask');
    Route::get('/bidPTIME/{id}', 'TaskminatorController@bidPtime');
    Route::get('/bidFTIME/{id}', 'TaskminatorController@bidFtime');
    Route::post('/initBid', 'TaskminatorController@initBid');
    Route::post('/doUploadDocuments', 'TaskminatorController@doUploadDocuments');
    Route::get('/taskDetails_{id}', 'TaskminatorController@taskDetails');
    Route::get('/tskmntr_taskOffers', 'TaskminatorController@tskmntr_taskOffers');
    Route::get('/tskmntr_taskBids', 'TaskminatorController@tskmntr_taskBids');
    Route::get('/tskmntr_onGoing', 'TaskminatorController@tskmntr_onGoing');
    Route::get('/tskmntr_completed', 'TaskminatorController@tskmntr_completed');
    Route::get('/cancelBid/{id}', 'TaskminatorController@cancelBid');
    Route::get('/viewClient_{id}', 'TaskminatorController@viewClient');
    Route::get('/confirmOffer/{taskid}', 'TaskminatorController@confirmOffer');
    Route::get('/denyOffer/{taskid}', 'TaskminatorController@denyOffer');
    Route::get('/editPersonalInfo', 'TaskminatorController@editPersonalInfo');
    Route::get('/editContactInfo', 'TaskminatorController@editContactInfo');
    Route::get('/editSkillInfo', 'TaskminatorController@editSkillInfo');
    Route::post('/doEditPersonalInfo', 'TaskminatorController@doEditPersonalInfo');
    Route::post('/doEditContactInfo', 'TaskminatorController@doEditContactInfo');
    Route::post('/doEditSkillInfo', 'TaskminatorController@doEditSkillInfo');
    Route::get('/removeSkill={taskitemId}', 'TaskminatorController@removeSkill');
    Route::get('/editPass', 'TaskminatorController@editPass');
    Route::post('/doEditPass', 'TaskminatorController@doEditPass');

    // sms verification
    Route::get('/doVerifyMobileNumber', 'TaskminatorController@doVerifyMobileNumber');
    Route::post('/verifyPin', 'TaskminatorController@verifyPin');
    Route::get('/sendVerificationCode', 'TaskminatorController@sendVerificationCode');
});

Route::group(array('before' => 'CLIENT-ONLY'), function(){
    // THE ROLE BASED ROUTES FOR CLIENT GOES HERE
    Route::get('/createTask', 'ClientIndiController@createTask');
    Route::post('/createTask', 'ClientIndiController@doCreateTask');
    Route::get('/editTask/{id}', 'ClientIndiController@editTask');
    Route::get('/deleteTask/{id}', 'ClientIndiController@deleteTask'); // this is actually "CANCEL" task
    Route::post('/doEditTask', 'ClientIndiController@doEditTask');
    Route::get('/tasks', 'ClientIndiController@tasks');
    Route::get('/taskDetails/{id}', 'ClientIndiController@taskDetails');
    Route::get('/hireTskmntr/{userid}/{taskid}', 'ClientIndiController@hireTskmntr');
    Route::get('/tskmntrSearch', 'ClientIndiController@tskmntrSearch');
    Route::get('/doTskmntrSearch={searchField}={searchKeyword}={city}', 'ClientIndiController@doTskmntrSearch');
    Route::get('/viewTaskminator_{id}', 'ClientIndiController@viewTaskminator');
    Route::get('/directHire_{id}', 'ClientIndiController@directHire');
    Route::get('/doDirectHire_{taskminatorid}.{taskid}', 'ClientIndiController@doDirectHire');
    Route::get('/retractOffer/{taskId}/{tskmntrId}', 'ClientIndiController@retractOffer');
    Route::get('/completeTask/taskid:{taskid}', 'ClientIndiController@completeTask');
    Route::post('/rateTaskminator', 'ClientIndiController@rateTaskminator');
    Route::get('/accomplishedTasks', 'ClientIndiController@accomplishedTasks');
    Route::get('/cancelledTasks', 'ClientIndiController@cancelledTasks');
    Route::get('/automaticSearch/{taskId}', 'ClientIndiController@automaticSearch');
    Route::get('/automaticOffer/{taskId}={userid}', 'ClientIndiController@automaticOffer');
    Route::get('/cltEditPersonalInfo', 'ClientIndiController@cltEditPersonalInfo');
    Route::get('/cltEditContactInfo', 'ClientIndiController@cltEditContactInfo');
    Route::get('/cltEditAcctInfo', 'ClientIndiController@cltEditAcctInfo');
    Route::post('/doCltEditPersonalInfo', 'ClientIndiController@doCltEditPersonalInfo');
    Route::post('/doCltEditContactInfo', 'ClientIndiController@doCltEditContactInfo');
    Route::post('/doCltEditIndiContactInfo', 'ClientIndiController@doCltEditIndiContactInfo');
    Route::post('/doCltEditPass', 'ClientIndiController@doCltEditPass');
    Route::post('/doCltIndiEditPersonalInfo', 'ClientIndiController@doCltIndiEditPersonalInfo');
});

// THIS FUNCTION IS FOR ROUTE PROTECTION - IT REDIRECTS THE SYSTEM WHEN THE ROUTE/METHOD IS NOT FOUND AND/OR DOESN'T EXIST - Jan Sarmiento
//App::missing(function(){
//    return Redirect::to('/');
//});

// THIS FUNCTION REDIRECTS USER TO INDEX or '/' IF THE PAGE MAKES AN ERROR - Jan Sarmiento
//App::error(function(){
//    return Redirect::to('/');
//});