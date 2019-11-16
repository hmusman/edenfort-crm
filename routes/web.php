<?php
ini_set('memory_limit', '2024M');

Route::post('assign-singlecoldcalling','adminColdCallingController@singlePersonColdCalling');

// PDF REPORT
Route::get('direct-pdf-report', 'directPdfReportController@index');
Route::post('direct-pdf-report', 'directPdfReportController@generate');


Route::get('backup', 'BackupController@index');
Route::get('backup/create', 'BackupController@create');
Route::get('backup/download/{file_name?}', 'BackupController@download');
Route::get('backup/delete/{file_name?}', 'BackupController@delete')->where('file_name', '(.*)');


Route::get('loans', 'loanController@index');
Route::post('add-loan', 'loanController@addLoan');
Route::get('edit-loan/{id}', 'loanController@editLoan');
Route::post('update-loan', 'loanController@updateLoan');
Route::get('add-paid-amount', 'loanController@addPaidAmount');


Route::get('get-months-deals', 'dealController@getRecentDeals');
Route::get('months', 'dealController@months');
Route::get('close-month', 'dealController@closeMonth');

Route::get('email-templates', 'emailTemplateController@index');
Route::post('add-email-template', 'emailTemplateController@addTemplate');
Route::get('edit-template/{id}', 'emailTemplateController@editTemplate');
Route::post('update-email-template/{id}', 'emailTemplateController@updateTemplate');
Route::get('delete-template/{id}', 'emailTemplateController@deleteTemplate');
//===================REMINDER MODULES ROUTES=================================
    // Reminders ROUTES
    Route::get('get-reminder', 'reminderController@getReminders');
    Route::get('delete-reminder', 'reminderController@deleteReminder');
    Route::get('get-all-reminder', 'reminderController@getallReminder');
    Route::get('get-reminder-record', 'reminderController@getreminderRecord');
    
    Route::get('get-all-agents-reminder', 'getAgentReminders@index');
    
    
//===================COLDCALLING MODULES=================================
    //===================ADMIN COLDCALLING MODULES=================================
    // ColdCalling WHATSAPP
    Route::get('/whatsApp-msgs', 'adminColdCallingController@whatsAppMsgs');
    Route::get('/whatsApp-Ownermsgs', 'adminColdCallingController@whatsAppOwnerMsgs');
    // COLD CALLING ROUTES
    Route::get('/coldCalling', 'adminColdCallingController@coldCalling');
    Route::get('setReminderForColdCalling', 'adminColdCallingController@setReminderForColdCalling');
    Route::get('setReminderByRow', 'adminColdCallingController@setReminderByRow');
    Route::get('updateColdCallingRow', 'adminColdCallingController@updateColdCallingRow');
    Route::get('bulkUpdateStatusColdCalling','adminColdCallingController@bulkUpdateStatusColdCalling');
    //coldcalling Search Filters
    Route::get('/coldcallingsearch','adminColdCallingController@coldCalling')->name('coldcallingsearch');
    Route::post('coldcallingsearch','adminColdCallingController@coldCalling')->name('coldcallingsearch');
    //cold calling search bar
    Route::get('/caldCallingSearchBar','adminColdCallingController@coldCalling');
    Route::post('/caldCallingSearchBar','adminColdCallingController@coldCalling');
    //===================AGENT COLDCALLING MODULES=================================
    // AGENT COLDCALLING
       Route::get('/whatsApp-msgsForColdCalling', 'agentColdCallingController@whatsAppMsgsForProperty');
    Route::get('/whatsApp-OwnermsgsForColdCalling', 'agentColdCallingController@whatsAppOwnerMsgsForProperty');
    
    Route::get('/agentColdCalling', 'agentColdCallingController@index');
    Route::get('agentsetReminderForColdCalling', 'agentColdCallingController@setReminderForColdCalling');
    Route::get('agentSetReminderByRow', 'agentColdCallingController@setReminderByRow');
    Route::get('agentUpdateColdCallingRow', 'agentColdCallingController@updateColdCallingRow');
    Route::get('agentBulkUpdateStatusColdCalling','agentColdCallingController@bulkUpdateStatusColdCalling');
    Route::get('/agentcoldcallingsearch','agentColdCallingController@index')->name('agentcoldcallingsearch');
    //agentColdCalling Search bar
    Route::get('/agentColdCallingSearchBar','agentColdCallingController@index');
    Route::post('/agentColdCallingSearchBar','agentColdCallingController@index');


//===================PROPERTY MODULES=================================
    // =======ADMIN SIDE PROPERTY MODULE==============
    
    Route::get('/whatsApp-msgsForProperty', 'adminPropertyController@whatsAppMsgsForProperty');
    Route::get('/whatsApp-OwnermsgsForProperty', 'adminPropertyController@whatsAppOwnerMsgsForProperty');
    
    Route::get('/property', 'adminPropertyController@index');
    Route::get('setReminderForProperty', 'adminPropertyController@setReminderForProperty');
    Route::get('bulkUpdateStatusProperty','adminPropertyController@bulkUpdateStatusProperty');
    Route::get('/Propertysearch','adminPropertyController@index')->name('Propertysearch');
    Route::post('Addproperty', 'adminPropertyController@Addproperty');
    Route::get('Addproperty', 'adminPropertyController@Addproperty');
    Route::post('Editproperty', 'adminPropertyController@Editproperty');
    Route::get('EditProperty', 'adminPropertyController@EditProperty');
    Route::post('UpdateProperty', 'adminPropertyController@UpdateProperty');
    Route::get('UpdateProperty', 'adminPropertyController@UpdateProperty');
    Route::get('OwnerProperty', 'ownerController@OwnerProperty');
    Route::get('/addLandlordEmailPass', 'adminPropertyController@addLandlordEmailPass');
     Route::get('DeletePropertyByAdmin/{id}', 'adminPropertyController@DeleteProperty');
    // =======AGENT SIDE PROPERTY MODULE==============
    Route::get('/whatsAppMsgsForAgentProperty', 'agentPropertyController@whatsAppMsgsForProperty');
    Route::get('/whatsAppOwnerMsgsForAgentProperty', 'agentPropertyController@whatsAppOwnerMsgsForProperty');
    Route::get('/allAddedProperties', 'agentPropertyController@allAddedProperties');
    Route::get('bulkUpdateStatusPropertyAgent','agentPropertyController@bulkUpdateStatusProperty');
    Route::get('/setReminderForPropertyAgent', 'agentPropertyController@setReminderForProperty');
    Route::get('/PropertysearchForAgent','agentPropertyController@allAddedProperties')->name('PropertysearchForAgent');
    Route::get('EditPropertyByAgent', 'agentPropertyController@EditProperty');
    Route::get('/addPropertyByAgent', 'agentPropertyController@addProperty');
    Route::post('/addPropertyByAgent', 'agentPropertyController@addProperty');
    Route::post('/updatePropertyByAgent', 'agentPropertyController@updatePropertyByAgent');
    //filters for agent
    Route::get('searchAgent','agentPropertyController@allAddedProperties')->name('searchAgent');
    Route::post('searchAgent','agentPropertyController@allAddedProperties')->name('searchAgent');
    
    Route::get('AddpropertyAgent','agentPropertyController@Addproperty');
    Route::post('AddpropertyAgent','agentPropertyController@Addproperty');
   
//===================DASHBOARD MODULES=================================
    // =======AGENT SIDE DASHBOARD MODULE==============
    Route::get('agentdashboard', 'agentPropertyController@index');
// ADD SALARAY

Route::get('add-salary', 'dealController@addSalary');

Route::get('update-percentage', 'dealController@updatePercentage');
Route::get('export-salary', 'PdfGenerateController@exportSalary');
Route::get('sent-cold-calling-emails', 'adminColdCallingController@sentEmails');
Route::get('sent-property-emails', 'adminPropertyController@sentEmails');

Route::get('agent-sent-cold-calling-emails', 'agentColdCallingController@sentEmails');
Route::get('agent-sent-property-emails', 'agentPropertyController@sentEmails');

// Supervision
Route::post('add-owner-by-ajax','SupervisionController@addOwnerByAjax');
Route::get('dashboard','SupervisionController@dashboard');
Route::get('/owners', 'userController@owners');
Route::get('/agents', 'userController@agents');
Route::get('/admins', 'userController@admins');
Route::get('/supervision','SupervisionController@Supervision');
Route::post('/AddSupervison','SupervisionController@AddSupervison');
Route::get('/AddSupervison','SupervisionController@AddSupervison');
Route::get('/SupervisionBulkActions','SupervisionController@SupervisionBulkActions');
Route::get('/EditSupervision','SupervisionController@EditSupervision');
Route::post('/UpdateSupervision','SupervisionController@UpdateSupervision');
Route::get('generate-pdf', 'PdfGenerateController@pdfview')->name('generate-pdf');

Route::get('/properties', function () {
    return view('properties');
});
//deals
Route::get('/dealsInfo','dealController@index');
Route::get('/dealForm','dealController@insert')->name('dealForm');
Route::post('/dealForm','dealController@insert')->name('dealForm');
//edit Deal
Route::get('/editDeal','dealController@update')->name('editDeal');
Route::post('/editDeal','dealController@update')->name('editDeal');
Route::get('add-reminder-by-ajaxDealReminder', 'reminderController@insertDealReminder');
//leads
// Route::get('/agentLead','leadController@index');
// Route::get('/leadForm','leadController@insert');
// Route::post('/leadForm','leadController@insert');
// Route::get('/addEmailPhone', 'leadController@addEmailPhone');
// Route::get('add-contact-by-ajax', 'leadController@insertContactByAjax');

//route for sending agent Daail Report to admin by mail
Route::get('agentDailyReport','leadController@agentDailyReport');
//route for sending agent Daail Report to admin by mail
Route::get('/agentLead','leadController@index');
Route::get('/leadForm','leadController@insert');
Route::post('/leadForm','leadController@insert');

Route::get('/addEmailPhone', 'leadController@addEmailPhone');
Route::get('add-contact-by-ajax', 'leadController@insertContactByAjax');
//lead Reminder
Route::get('add-reminder-by-ajax', 'reminderController@insertLeadReminder');
Route::get('add-viewDateReminder-by-ajax', 'reminderController@insertLeadReminder');
//assignLead
Route::get('/assignLead','leadController@assignLead');
Route::post('/assignLead','leadController@assignLead');
//lead Update Form
Route::get('/leadUpdateForm','leadController@update');
Route::post('/leadUpdateForm','leadController@update');
//lead Search
Route::get('/leadSearch','leadController@index')->name('leadSearch');
Route::post('/leadSearch','leadController@index')->name('leadSearch');



//lead Reminder
Route::get('add-reminder-by-ajax', 'reminderController@insertLeadReminder');
Route::get('add-viewDateReminder-by-ajax', 'reminderController@insertLeadReminder');
//assignLead
Route::get('/assignLead','leadController@assignLead');
Route::post('/assignLead','leadController@assignLead');
//lead Update Form
Route::get('/leadUpdateForm','leadController@update');
Route::post('/leadUpdateForm','leadController@update');
//lead search
Route::get('/leadSearch','leadController@index')->name('leadSearch');
Route::post('/leadSearch','leadController@index')->name('leadSearch');
//bulk editing in leads
Route::get('bulkUpdateStatusLeads','leadController@bulkUpdateStatusLeads');
// Route::get('/agentLead', function () {
//     return view('agentLeadReport');
// });
//agentLeads
Route::get('/leads','agentLeadController@index');
Route::get('/agentleadForm','agentLeadController@insert');
Route::post('/agentleadForm','agentLeadController@insert');

Route::get('/addagentEmailPhone', 'agentLeadController@addEmailPhone');
Route::get('add-agent-contact-by-ajax', 'agentLeadController@insertContactByAjax');
//assignLead

//lead Update Form
Route::get('/agentleadUpdateForm','agentLeadController@update');
Route::post('/agentleadUpdateForm','agentLeadController@update');
//lead Search
Route::get('/agentleadSearch','agentLeadController@index')->name('agentleadSearch');
Route::post('/agentleadSearch','agentLeadController@index')->name('agentleadSearch');
//bulk editing in leads
Route::get('bulkUpdateStatusAgentLeads','agentLeadController@bulkUpdateStatusLeads');
//end of agentLeads

// Ali Routes for user/Owners
Route::get('/checkUsername', 'userController@checkUsername');
Route::post('/insert','userController@insertUser');
Route::post('/updateUser/{id}','userController@updateUser');
Route::get('/EditUser/{id}','userController@EditUser');
////mubeen//
Route::post('/change-password','userController@changePassword');
Route::get('/change-password','userController@changePassword');
///////////
Route::post('/CheckLogin','loginController@CheckLogin');
Route::get('/CheckLogin','loginController@CheckLogin');
Route::get('/logout', 'loginController@logout');
Route::get('/', function () {
    return view('login');
});
Route::get('forget-password/', function () {
    return view('forget-password');
});
Route::post('/reset-password', 'loginController@resetPassword');
// owner
Route::get('/owner', 'ownerController@ownerDashboard');
Route::get('/ownerdashboard','ownerController@ownerDashboard');




// buildings
Route::get('buildings', 'buildingController@index');
Route::post('insert-building', 'buildingController@insertBuilding');
Route::get('add-building-by-ajax', 'buildingController@insertBuildingByAjax');
Route::get('insert-building', 'buildingController@insertBuilding');
Route::get('delete-building', 'buildingController@deleteBuilding');
Route::get('edit-building', 'buildingController@editBuilding');
Route::post('update-building', 'buildingController@updateBuilding');
Route::get('update-building', 'buildingController@updateBuilding');
// agent


///////activity///
Route::get('/AgentActivity','ActivityController@agentsAll');
Route::get('/agentActivityProperties','ActivityController@agentActivityProperties');
//filter for admin


//menu's contrtoller
Route::get('/menu','menuController@index');


//for upcming
Route::get('/changeStatus', 'SupervisionController@changeStatus');
//for checkavailabilty
Route::get('/checkavailabilty', 'SupervisionController@checkavailabilty');
//for pending
Route::get('/pending', 'SupervisionController@pending');


Route::get('dealsAccountStatement','dealController@getDeals');

Route::get('/get-agents-reports', 'getAgentsReportsController@index');
Route::get('/get-agents-leads-reports', 'getAgentLeadsReport@index');

// agent
Route::get('agentColdCallingSidePropertyFilters', 'agentPropertyController@agentColdCallingSidePropertyFilters');
Route::get('agentSidePropertyFilters', 'agentPropertyController@agentSidePropertyFilters');
Route::get('agent-buildings', 'agentPropertyController@agentBuildings');
Route::get('view-agent-properties', 'agentPropertyController@viewAgentProperties');
Route::get('/agentProperty', 'agentPropertyController@agentProperty');
Route::get('/agentUpcomingpProperty', 'agentPropertyController@upcomingProperty');
Route::get('/agentRentProperty', 'agentPropertyController@rentProperty');
Route::get('/filterAgentProperties', 'agentPropertyController@filterAgentProperties');
Route::get('/agentForSaleProperty', 'agentPropertyController@saleProperty');
Route::get('/get-agent-reminder-record', 'agentPropertyController@getAgentReminderRecord');
//Route::get('/allAddedProperties', 'agentPropertyController@allAddedProperties');
// Route::get('EditPropertyByAgent', 'agentPropertyController@EditProperty');
Route::get('/addLandlordEmailPassByAgent', 'agentPropertyController@addLandlordEmailPass');
Route::get('/PropertyBulkActionsByAgent', 'agentPropertyController@PropertyBulkActionsByAgent');
Route::get('/agentProperties','agentPropertyController@agentProperties');
Route::get('/buildingProperties','agentPropertyController@buildingProperties');
Route::get('/assignAgent','agentPropertyController@assignAgent');
Route::post('insert-buildingAssign', 'agentPropertyController@insertbuildingAssign');
Route::get('insert-buildingAssign', 'agentPropertyController@insertbuildingAssign');
Route::get('delete-buildingAssign', 'agentPropertyController@deleteBuildingAssign');
Route::get('edit-buildingAssign', 'agentPropertyController@editBuildingAssign');
Route::post('update-buildingAssign', 'agentPropertyController@updateBuildingAssign');
Route::get('/bedProperties','agentPropertyController@bedProperties');
Route::get('/areaProperties','agentPropertyController@areaProperties');
Route::post('/insert-building-agent', 'agentPropertyController@insert_agentBuilding');
Route::get('delete-agent-building', 'agentPropertyController@deleteBuilding');
Route::get('edit-building-agent/{id}', 'agentPropertyController@editBuilding');
Route::post('update-building-agent/{id}', 'agentPropertyController@updateBuilding');
//filter for assignAgent
 Route::get('searchAssignAgent','agentPropertyController@assignAgent')->name('searchAssignAgent');
Route::post('searchAssignAgent','agentPropertyController@assignAgent')->name('searchAssignAgent');
//agentColdCalling Search Filters
// Route::get('/agentcoldcallingsearch','agentPropertyController@coldCalling')->name('agentcoldcallingsearch');
// Route::post('agentcoldcallingsearch','agentPropertyController@coldCalling')->name('agentcoldcallingsearch');
///////activity///
Route::get('/AgentActivity','ActivityController@agentsAll');
Route::get('/agentActivityProperties','ActivityController@agentActivityProperties');
//filter for admin
Route::get('search-result','PropertyController@index')->name('search');
Route::post('search-result','PropertyController@index')->name('search');

//filters for agent
Route::get('searchAgent','agentPropertyController@allAddedProperties')->name('searchAgent');
Route::post('searchAgent','agentPropertyController@allAddedProperties')->name('searchAgent');

//submitted Properties from the edenfort Main Website
Route::get('submittedProperties','submittedPropertyController@index');
Route::get('submitPropertyUpdateForm','submittedPropertyController@update');
Route::post('submitPropertyUpdateForm','submittedPropertyController@update');
Route::get('bulkUpdateSubmittedProperty','submittedPropertyController@bulkUpdateSubmittedProperty');
//filter
Route::get('submittedPropertySearch','submittedPropertyController@index')->name('submittedPropertySearch');

//Permissions
Route::get('permission','permissionController@index');
//permission Update Form
Route::get('permissionUpdateForm','permissionController@permissionUpdateForm');
Route::post('permissionUpdateForm','permissionController@permissionUpdateForm');
//permission Filter Form
Route::get('filterPermissionUser','permissionController@index');
Route::post('filterPermissionUser','permissionController@index');
