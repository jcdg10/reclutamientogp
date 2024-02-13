<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RecruiterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\ServicioRequeridoController;

use App\Http\Controllers\Request\RequestController;
use App\Http\Controllers\Request\RequestGeneralController;
use App\Http\Controllers\Request\RequestPersonalController;
use App\Http\Controllers\Request\RequestAcademicController;
use App\Http\Controllers\Request\RequestJobController;
use App\Http\Controllers\Request\RequestAdditionalController;
use App\Http\Controllers\Request\RequestEconomicController;
use App\Http\Controllers\Request\RequestProcessController;
use App\Http\Controllers\Request\RequestFinalController;

Route::get('/login',[UserController::class,'showLogin'])->name('show.login');
Route::post('/login', [LoginController::class,'login'])->name('login');
Route::get('/recuperar-password', [UserController::class,'showForgotForm'])->name('recuperar-password.form');
Route::post('/recuperar-password',[UserController::class,'sendResetLink'])->name('recuperar-password.form.link');
Route::get('/recuperar-password/reset',[UserController::class,'showResetForm'])->name('reset.password.form');
Route::post('/password/reset/{token}',[UserController::class,'resetPassword'])->name('reset.password');


Route::group(['middleware' => ['auth']], function() {

    Route::get('/',[DashboardController::class,'showDash'])->name('showDash');
    Route::get('/perfil',[UserController::class,'profile'])->name('profile');

    /*USERS*/
    Route::resource('usersactions', UserController::class);
    Route::put('/usersedit',[UserController::class,'update'])->name('updateusers');
    Route::get('usuarios',[UserController::class,'showUsuarios'])->name('showUsuarios');
    Route::get('index',[UserController::class,'index'])->name('index');

    /*APPLICANT*/
    Route::resource('applicantactions', ApplicantController::class);
    Route::post('/applicantedit/{id}',[ApplicantController::class,'update']);
    Route::get('candidatos',[ApplicantController::class,'showApplicant'])->name('showApplicant');
    Route::get('applicant.index',[ApplicantController::class,'index']);
    Route::post('/processapplicantdataget',[ApplicantController::class,'processapplicantdataget'])->name('processapplicantdataget');
    Route::get('/addcandidatovacante',[ApplicantController::class,'addCandidatoVacante'])->name('addCandidatoVacante');
    Route::post('/applicantaddfile',[ApplicantController::class,'addfile'])->name('addfile');
    Route::get('/getfilesbyapplicant/{id}',[ApplicantController::class,'getfiles']);
    Route::delete('/deletefile/{id}',[ApplicantController::class,'deletefiles']);

    Route::post('/applicantacademico',  [ApplicantController::class,'addAcademico']);
    Route::post('applicant.getApplicantAcademic',  [ApplicantController::class,'getAcademic']);
    Route::get('/applicantacademico/{id}',  [ApplicantController::class,'getEspecificAcademic']);
    Route::delete('/applicantacademico/{id}',  [ApplicantController::class,'deleteAcademico']);
    Route::post('/applicantacademico/{id}',  [ApplicantController::class,'editAcademico']);

    Route::post('/applicantexperience',  [ApplicantController::class,'addExperience']);
    Route::post('applicant.getApplicantExperience', [ApplicantController::class,'getApplicantExperience']);
    Route::get('/applicantexperience/{id}',  [ApplicantController::class,'getExperience']);
    Route::delete('/applicantexperience/{id}',  [ApplicantController::class,'deleteExperience']);
    Route::post('/applicantexperience/{id}',  [ApplicantController::class,'editExperience']);


    /*CLIENTS*/
    Route::resource('clientactions', ClientController::class);
    Route::put('/clientedit',[ClientController::class,'update']);
    Route::get('clientes',[ClientController::class,'showClient'])->name('showClient');
    Route::get('client.index',[ClientController::class,'index']);

    /*RECRUITER*/
    Route::resource('recruiteractions', RecruiterController::class);
    Route::put('/recruiteredit',[RecruiterController::class,'update']);
    Route::get('reclutador',[RecruiterController::class,'showRecruiter'])->name('showRecruiter');
    Route::get('recruiter.index',[RecruiterController::class,'index']);

    /*CITY*/
    Route::resource('cityactions', CiudadController::class);
    Route::put('/cityedit',[CiudadController::class,'update']);
    Route::get('ciudad',[CiudadController::class,'showCiudad'])->name('showCiudad');
    Route::get('city.index',[CiudadController::class,'index']);

    /*SPECIALITY*/
    Route::resource('specialtyactions', EspecialidadController::class);
    Route::put('/specialtyedit',[EspecialidadController::class,'update']);
    Route::get('especialidad',[EspecialidadController::class,'showEspecialidad'])->name('showEspecialidad');
    Route::get('specialty.index',[EspecialidadController::class,'index']);

    /*SERVICIOS REQUERIDOS*/
    Route::resource('requiredserviceactions', ServicioRequeridoController::class);
    Route::put('/requiredserviceedit',[ServicioRequeridoController::class,'update']);
    Route::get('serviciorequerido',[ServicioRequeridoController::class,'showServicioRequerido'])->name('showServicioRequerido');
    Route::get('requiredservice.index',[ServicioRequeridoController::class,'index']);

    /*REPORT*/
    Route::resource('reportactions', ReportController::class);
    Route::put('/reportedit',[ReportController::class,'update']);
    Route::get('reporte',[ReportController::class,'showReport'])->name('showReport');
    Route::get('report.index',[ReportController::class,'index']);
    Route::get('/reportedownload/{id}',[ReportController::class,'download'])->name('download');
    Route::post('searchreport',[ReportController::class,'searchReport'])->name('searchReport');
    Route::post('searchdatachart',[ReportController::class,'searchDataChart'])->name('searchDataChart');

    /*VACANT REQUERIMIENTO*/
    Route::resource('requestactions', RequestController::class);
    Route::put('/requestedit',[RequestController::class,'update']);
    Route::get('requerimiento',[RequestController::class,'showRequest'])->name('showRequest');
    Route::get('requerimiento.index',[RequestController::class,'index']);
    Route::get('/getinfoclient/{id}',[RequestController::class,'getInfoClient'])->name('getInfoClient');

    //GENERAL DATA
    Route::post('/generaldata',[RequestGeneralController::class,'generalData'])->name('generalData');
    Route::post('/generaldataedit',[RequestGeneralController::class,'generalDataEdit'])->name('generalDataEdit');
    Route::get('/generaldataget/{id}',[RequestGeneralController::class,'generalDataGet'])->name('generalDataGet');

    //PERSONAL DATA
    Route::post('/personaldata',[RequestPersonalController::class,'personalData'])->name('personalData');
    Route::post('/personaldataedit',[RequestPersonalController::class,'personalDataEdit'])->name('personalDataEdit');
    Route::get('/personaldataget/{id}',[RequestPersonalController::class,'personalDataGet'])->name('personalDataGet');

    //ACADEMIC DATA
    Route::post('/academicdata',[RequestAcademicController::class,'academicData'])->name('academicData');
    Route::post('/academicdataedit',[RequestAcademicController::class,'academicDataEdit'])->name('academicDataEdit');
    Route::get('/academicdataget/{id}',[RequestAcademicController::class,'academicDataGet'])->name('academicDataGet');

    //JOB DATA
    Route::post('/jobdata',[RequestJobController::class,'jobData'])->name('jobData');
    Route::post('/jobdataedit',[RequestJobController::class,'jobDataEdit'])->name('jobDataEdit');
    Route::get('/jobdataget/{id}',[RequestJobController::class,'jobDataGet'])->name('jobDataGet');

    //ADDIOTIONAL DATA
    Route::post('/additionaldata',[RequestAdditionalController::class,'additionalData'])->name('additionalData');
    Route::post('/additionaldataedit',[RequestAdditionalController::class,'additionalDataEdit'])->name('additionalDataEdit');
    Route::get('/additionaldataget/{id}',[RequestAdditionalController::class,'additionalDataGet'])->name('additionalDataGet');

    //ECONOMIC DATA
    Route::post('/economicdata',[RequestEconomicController::class,'economicData'])->name('economicData');
    Route::post('/economicdataedit',[RequestEconomicController::class,'economicDataEdit'])->name('economicDataEdit');
    Route::get('/economicdataget/{id}',[RequestEconomicController::class,'economicDataGet'])->name('economicDataGet');

    //PROCESS DATA
    Route::post('/processdata',[RequestProcessController::class,'processData'])->name('processData');
    Route::post('/processdataedit',[RequestProcessController::class,'processDataEdit'])->name('processDataEdit');
    Route::get('/processdataget/{id}',[RequestProcessController::class,'processDataGet'])->name('processDataGet');

    //FINAL DATA
    Route::post('/finaldata',[RequestFinalController::class,'finalData'])->name('finalData');
    Route::post('/finaldataedit',[RequestFinalController::class,'finalDataEdit'])->name('finalDataEdit');
    Route::get('/finaldataget/{id}',[RequestFinalController::class,'finalDataGet'])->name('finalDataGet');

    //to update the information
    Route::post('/clientdataedit',[RequestController::class,'clientDataEdit'])->name('clientDataEdit');
    
    //to get the information
    Route::get('/clientdataget/{id}',[RequestController::class,'clientDataGet'])->name('clientDataGet');
    
    //accept requirement
    Route::get('/statusrequirement',[RequestController::class,'statusRequirement'])->name('statusRequirement');
    Route::get('/getrecruitment',[RequestController::class,'getRecruitment'])->name('getRecruitment');
    Route::post('/getapplicant',[RequestController::class,'getApplicant'])->name('getApplicant');
    Route::post('/saverecruitment',[RequestController::class,'saveRecruitment'])->name('saveRecruitment');
    Route::post('/saveapplicant',[RequestController::class,'saveApplicant'])->name('saveApplicant');
    //PDF
    Route::post('vacant.getpdf', [RequestController::class,'getPdf']);
    //Validate information
    Route::get('/validateinformation/{id}',[RequestController::class,'validateInformation'])->name('validateInformation');
    //add candidates
    Route::get('addapplicant.index',[RequestController::class,'addapplicant'])->name('addapplicant');
    Route::get('deleteapplicant.index',[RequestController::class,'deleteapplicant'])->name('deleteapplicant');
    Route::post('/addApplicantNew',[RequestController::class,'addApplicantNew'])->name('addApplicantNew');
    Route::delete('/deleteApplicantDo/{id}',[RequestController::class,'deleteApplicantDo'])->name('deleteApplicantDo'); 
    
    /*ROLE*/
    Route::resource('roleactions', RoleController::class);
    Route::post('/getPermisosModulo/{id}',[RoleController::class,'getPermisosModulo'])->name('getPermisosModulo');
    Route::post('/modifypermissions',[RoleController::class,'modifyPermissions'])->name('modifyPermissions');
    Route::put('/roleedit',[RoleController::class,'update']);
    Route::get('perfiles',[RoleController::class,'showRole'])->name('showRole');
    Route::get('role.index',[RoleController::class,'index']);
});

Route::get('/logout', 'App\Http\Controllers\LogoutController@perform')->name('logout.perform');

/*
Route::group(['prefix' => 'email'], function(){
    Route::get('inbox', function () { return view('pages.email.inbox'); });
    Route::get('read', function () { return view('pages.email.read'); });
    Route::get('compose', function () { return view('pages.email.compose'); });
});

Route::group(['prefix' => 'apps'], function(){
    Route::get('chat', function () { return view('pages.apps.chat'); });
    Route::get('calendar', function () { return view('pages.apps.calendar'); });
});

Route::group(['prefix' => 'ui-components'], function(){
    Route::get('accordion', function () { return view('pages.ui-components.accordion'); });
    Route::get('alerts', function () { return view('pages.ui-components.alerts'); });
    Route::get('badges', function () { return view('pages.ui-components.badges'); });
    Route::get('breadcrumbs', function () { return view('pages.ui-components.breadcrumbs'); });
    Route::get('buttons', function () { return view('pages.ui-components.buttons'); });
    Route::get('button-group', function () { return view('pages.ui-components.button-group'); });
    Route::get('cards', function () { return view('pages.ui-components.cards'); });
    Route::get('carousel', function () { return view('pages.ui-components.carousel'); });
    Route::get('collapse', function () { return view('pages.ui-components.collapse'); });
    Route::get('dropdowns', function () { return view('pages.ui-components.dropdowns'); });
    Route::get('list-group', function () { return view('pages.ui-components.list-group'); });
    Route::get('media-object', function () { return view('pages.ui-components.media-object'); });
    Route::get('modal', function () { return view('pages.ui-components.modal'); });
    Route::get('navs', function () { return view('pages.ui-components.navs'); });
    Route::get('navbar', function () { return view('pages.ui-components.navbar'); });
    Route::get('pagination', function () { return view('pages.ui-components.pagination'); });
    Route::get('popovers', function () { return view('pages.ui-components.popovers'); });
    Route::get('progress', function () { return view('pages.ui-components.progress'); });
    Route::get('scrollbar', function () { return view('pages.ui-components.scrollbar'); });
    Route::get('scrollspy', function () { return view('pages.ui-components.scrollspy'); });
    Route::get('spinners', function () { return view('pages.ui-components.spinners'); });
    Route::get('tabs', function () { return view('pages.ui-components.tabs'); });
    Route::get('tooltips', function () { return view('pages.ui-components.tooltips'); });
});

Route::group(['prefix' => 'advanced-ui'], function(){
    Route::get('cropper', function () { return view('pages.advanced-ui.cropper'); });
    Route::get('owl-carousel', function () { return view('pages.advanced-ui.owl-carousel'); });
    Route::get('sortablejs', function () { return view('pages.advanced-ui.sortablejs'); });
    Route::get('sweet-alert', function () { return view('pages.advanced-ui.sweet-alert'); });
});

Route::group(['prefix' => 'forms'], function(){
    Route::get('basic-elements', function () { return view('pages.forms.basic-elements'); });
    Route::get('advanced-elements', function () { return view('pages.forms.advanced-elements'); });
    Route::get('editors', function () { return view('pages.forms.editors'); });
    Route::get('wizard', function () { return view('pages.forms.wizard'); });
});

Route::group(['prefix' => 'charts'], function(){
    Route::get('apex', function () { return view('pages.charts.apex'); });
    Route::get('chartjs', function () { return view('pages.charts.chartjs'); });
    Route::get('flot', function () { return view('pages.charts.flot'); });
    Route::get('morrisjs', function () { return view('pages.charts.morrisjs'); });
    Route::get('peity', function () { return view('pages.charts.peity'); });
    Route::get('sparkline', function () { return view('pages.charts.sparkline'); });
});

Route::group(['prefix' => 'tables'], function(){
    Route::get('basic-tables', function () { return view('pages.tables.basic-tables'); });
    Route::get('data-table', function () { return view('pages.tables.data-table'); });
});

Route::group(['prefix' => 'icons'], function(){
    Route::get('feather-icons', function () { return view('pages.icons.feather-icons'); });
    Route::get('flag-icons', function () { return view('pages.icons.flag-icons'); });
    Route::get('mdi-icons', function () { return view('pages.icons.mdi-icons'); });
});

Route::group(['prefix' => 'general'], function(){
    Route::get('blank-page', function () { return view('pages.general.blank-page'); });
    Route::get('faq', function () { return view('pages.general.faq'); });
    Route::get('invoice', function () { return view('pages.general.invoice'); });
    Route::get('profile', function () { return view('pages.general.profile'); });
    Route::get('pricing', function () { return view('pages.general.pricing'); });
    Route::get('timeline', function () { return view('pages.general.timeline'); });
});

Route::group(['prefix' => 'auth'], function(){
    Route::get('login', function () { return view('pages.auth.login'); });
    Route::get('register', function () { return view('pages.auth.register'); });
});*/


Route::group(['prefix' => 'error'], function(){
    Route::get('404', function () { return view('pages.error.404'); });
    Route::get('500', function () { return view('pages.error.500'); });
});

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

// 404 for undefined routes
Route::any('/{page?}',function(){
    return View::make('pages.error.404');
})->where('page','.*');