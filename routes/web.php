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

// PROBABLY WE WILL USE THIS ALSO
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


Route::get ('/under',								'Frontend\HomeController@underConstruction')->name('under-construction');
Route::get ('/', 									'Frontend\HomeController@index')->name('home');
Route::get ('/dance-styles', 						'Frontend\StaticPagesController@danceClasses')->name('dance-classes');
Route::get ('/dance-styles/{name}', 				'Frontend\StaticPagesController@danceClassName')->name('dance-class-name');
Route::get ('/blog', 								'Frontend\StaticPagesController@blog')->name('blog');
Route::get ('/blog/{title}', 						'Frontend\StaticPagesController@blogArticle')->name('blog-article');
Route::get ('/events',        						'Frontend\StaticPagesController@events')->name('events');
Route::get ('/events/{name}',        				'Frontend\StaticPagesController@eventsName')->name('events-name');
Route::get ('/about-us',  	 						'Frontend\StaticPagesController@aboutUs')->name('about-us');
Route::get ('/timetable',  	 						'Frontend\StaticPagesController@timetable')->name('timetable');
Route::get ('/franchise', 	 						'Frontend\StaticPagesController@franchise')->name('franchise');
Route::get ('/services', 	 						'Frontend\StaticPagesController@services')->name('services');
Route::get ('/services/{name}', 	 				'Frontend\StaticPagesController@servicesName')->name('services-name');
Route::get ('/teachers', 	 						'Frontend\StaticPagesController@teachers')->name('teachers');
Route::get ('/teachers/{name}', 	 				'Frontend\StaticPagesController@teachersName')->name('teachers-name');
Route::get ('/contact',   	 						'Frontend\StaticPagesController@contact')->name('contact');
Route::post('/contact', 							'Frontend\StaticPagesController@storecontact');
Route::post('/store-newsletter',					'Frontend\StaticPagesController@storeNewsletter')->name('store-newsletter');
Route::get ('/reviews', 	 						'Frontend\StaticPagesController@reviews')->name('reviews');


Route::get('/ajaxLoad/{what}', 						'Frontend\HomeController@ajaxLoad')->name('ajaxLoad');

////////////// ACCOUNT ROUTES //////////////////////
Route::get ('/account/define-account',				'Backend\AccountController@defineAccount')->name('define-account');
Route::get ('/account',								'Backend\AccountController@account')->name('account');
Route::post('/account/complete-profile',	  		'Backend\AccountController@completeProfile')->name('complete-profile');
Route::get ('/account/reset-password', 				'Backend\AccountController@showResetForm')->name('reset-password');
Route::get ('/account/reset-password-2',  			'Backend\AccountController@showResetFormAccount')->name('reset-password-account');

Route::get ('/account/earn-points', 				'Backend\AccountController@earnPoints')->name('earn-points');
Route::get ('/account/how-it-works', 				'Backend\AccountController@howItWorks')->name('how-it-works');
Route::get ('/account/earn-by-referral', 			'Backend\AccountController@earnByReferral')->name('earn-by-referral');


Route::get ('/account/join-courses', 				'Backend\AccountController@joinCourses')->name('account-join-courses');
Route::get ('/account/subscribe', 					'Backend\AccountController@subscribe')->name('account-subscribe');
Route::post('/account/subscribe-post', 				'Backend\AccountController@subscribePost')->name('account-subscribe-post');
Route::get ('/account/join-events', 				'Backend\AccountController@joinEvents')->name('account-join-events');


Route::post('/account/add-event-booking', 			'Backend\AccountController@addEventBooking')->name('add-event-booking');
Route::post('/account/aprove-event-booking', 		'Backend\AccountController@aproveEventBooking')->name('aprove-event-booking');

Route::post('/account/book-now-course', 			'Backend\AccountController@bookNowCourse')->name('book-now-course');

Route::get ('/account/claim-prize', 				'Backend\AccountController@claimPrize')->name('account-claim-prize');


Route::post('/account/add-friend', 					'Backend\AccountController@addFriend')->name('add-friend');
Route::post('/account/send-invitation', 			'Backend\AccountController@sendInvitation')->name('send-invitation');
Route::post('/account/add-points-referrer', 		'Backend\AccountController@addPointsReferrer')->name('add-points-referrer');

////////////// END ACCOUNT ROUTES //////////////////////


////////////// SUPER ADMIN ROUTES //////////////////////
Route::get('/super-admin',							'Backend\SuperAdminController@superAdminFirstPage')->name('super-admin-first-page');
Route::get('/super-admin/franchise',				'Backend\SuperAdminController@superAdminFranchise')->name('super-admin-franchise');
////////////// END SUPER ADMIN ROUTES //////////////////


////////////// ADMIN ROUTES //////////////////////
//Route::get('/super-admin',				'Backend\SuperAdminController@superAdminFirstPage')->name('super-admin-first-page');
//Route::get('/super-admin/franchise',	'Backend\SuperAdminController@superAdminFranchise')->name('super-admin-franchise');
////////////// END SUPER ADMIN ROUTES //////////////////


////////////// MY SCHOOLS ROUTES  //////////////////////
Route::get ('/admin/my-school',						'Backend\MyschoolController@mySchool')->name('my-school');
Route::get ('/admin/about-us',						'Backend\MyschoolController@adminAboutUs')->name('admin-about-us');
Route::post('/admin/about-us-post',					'Backend\MyschoolController@adminAboutUsPost')->name('admin-about-us-post');
Route::get ('/admin/quotes',						'Backend\MyschoolController@adminQuotes')->name('admin-quotes');
Route::post('/admin/quotes-post',					'Backend\MyschoolController@adminQuotesPost')->name('add-quotes');
Route::post('/admin/complete-school-details',		'Backend\MyschoolController@completeSchoolDetails')->name('complete-school-details');
Route::get ('/admin/dance-classes',					'Backend\MyschoolController@danceClasses')->name('my-school-dance-classes');
Route::post('/admin/add-dance-class',				'Backend\MyschoolController@addDanceClass')->name('add-dance-class');
Route::get ('/admin/services',						'Backend\MyschoolController@services')->name('admin-services');
Route::post('/admin/add-services',					'Backend\MyschoolController@addServices')->name('add-services');
Route::get ('/admin/plans',							'Backend\MyschoolController@plans')->name('admin-plans');
Route::post('/admin/add-plan',						'Backend\MyschoolController@addPlan')->name('add-plan');
Route::get ('/admin/levels',						'Backend\MyschoolController@levels')->name('admin-levels');
Route::post('/admin/add-level',						'Backend\MyschoolController@addLevel')->name('add-level');
Route::get ('/admin/dance-courses',					'Backend\MyschoolController@danceCourses')->name('my-school-dance-courses');
Route::post('/admin/add-dance-course',				'Backend\MyschoolController@addDanceCourses')->name('add-dance-course');
Route::get ('/admin/my-school-teachers',			'Backend\MyschoolController@mySchoolTeachers')->name('my-school-teachers');
Route::post('/admin/add-teacher',					'Backend\MyschoolController@addSchoolTeachers')->name('add-school-teachers');
Route::post('/admin/update-teacher-profile',		'Backend\MyschoolController@updateTeacherProfile')->name('update-teacher-profile');
Route::get ('/admin/my-school-students',			'Backend\MyschoolController@mySchoolStudents')->name('my-school-students');
Route::get ('/admin/my-school-removed-students',	'Backend\MyschoolController@mySchoolRemovedStudents')->name('my-school-removed-students');
Route::post('/admin/add-student',					'Backend\MyschoolController@addSchoolStudent')->name('add-school-student');
Route::post('/admin/edit-student',					'Backend\MyschoolController@editSchoolStudent')->name('edit-school-student');
Route::post('/admin/edit-student-comments',			'Backend\MyschoolController@editSchoolStudentComments')->name('edit-school-student-comments');
Route::post('/admin/update-student-points',			'Backend\MyschoolController@updateStudentPoints')->name('update-student-points');
Route::post('/admin/remove-student',		    	'Backend\MyschoolController@removeStudent')->name('remove-student');
Route::post('/admin/activate-student',		    	'Backend\MyschoolController@activateStudent')->name('activate-student');
Route::post('/admin/update-student-payment',		'Backend\MyschoolController@updateStudentPayment')->name('update-student-payment');
Route::post('/admin/add-school-student-no-account',	'Backend\MyschoolController@addSchoolStudentNoAccount')->name('add-school-student-no-account');
Route::get ('/admin/my-school-users',				'Backend\MyschoolController@mySchoolUsers')->name('my-school-users');
Route::get ('/admin/my-school-events',				'Backend\MyschoolController@mySchoolEvents')->name('my-school-events');
Route::post('/admin/add-events',					'Backend\MyschoolController@addEvents')->name('add-events');
Route::get ('/admin/my-school-payments',			'Backend\MyschoolController@mySchoolPayments')->name('my-school-payments');
Route::get ('/admin/admin-newsletter',				'Backend\MyschoolController@adminNewsletter')->name('admin-newsletter');
Route::post('/admin/admin-newsletter-post',			'Backend\MyschoolController@adminNewsletterPost')->name('admin-newsletter-post');
Route::post('/admin/activate-payment',				'Backend\MyschoolController@activatePayment')->name('activate-payment');


Route::get ('/admin/blog',							'Backend\MyschoolController@blog')->name('admin-blog');
Route::post('/admin/add-blog-article',				'Backend\MyschoolController@addBlogArticle')->name('add-blog-article');
Route::get ('/admin/reviews',						'Backend\MyschoolController@reviews')->name('admin-reviews');
Route::post('/admin/add-review',				 'Backend\MyschoolController@addReview')->name('add-review');

//Route::post('/admin/add-user',						'Backend\MyschoolController@addSchoolStudent')->name('add-school-student');
////////////// END SUPER ADMIN ROUTES //////////////////


///////////// datatables /////////////////////////////////
Route::get('/datatables/datatable-franchise',		'Backend\DatatableController@datatableFranchise')->name('datatable-franchise');
Route::get('/datatables/datatable-dance-classes',	'Backend\DatatableController@datatableDanceClasses')->name('datatable-dance-classes');
Route::get('/datatables/datatable-services',		'Backend\DatatableController@datatableServices')->name('datatable-services');
Route::get('/datatables/datatable-plans',			'Backend\DatatableController@datatablePlans')->name('datatable-plans');
Route::get('/datatables/datatable-levels',			'Backend\DatatableController@datatableLevels')->name('datatable-levels');
Route::get('/datatables/datatable-dance-courses',	'Backend\DatatableController@datatableDanceCourses')->name('datatable-dance-courses');
Route::get('/datatables/datatable-dance-courses-u',	'Backend\DatatableController@datatableDanceCoursesu')->name('datatable-dance-courses-U');
Route::get('/datatables/datatable-prize-courses',	'Backend\DatatableController@datatableDanceCoursesPrize')->name('datatable-dance-courses-prize');
Route::get('/datatables/datatable-teachers',		'Backend\DatatableController@datatableTeachers')->name('datatable-teachers');
Route::get('/datatables/datatable-school-students',	'Backend\DatatableController@datatableSchoolStudents')->name('datatable-school-students');
Route::get('/datatables/datatable-school-removed-students',	'Backend\DatatableController@datatableSchoolRemovedStudents')->name('datatable-school-removed-students');
Route::get('/datatables/datatable-school-users',	'Backend\DatatableController@datatableSchoolUsers')->name('datatable-school-users');
Route::get('/datatables/datatable-school-payments',	'Backend\DatatableController@datatableSchoolPayments')->name('datatable-school-payments');
Route::get('/datatables/datatable-events',			'Backend\DatatableController@datatableEvents')->name('datatable-events');
Route::get('/datatables/datatable-quotes',			'Backend\DatatableController@datatableQuotes')->name('datatable-quotes');
Route::get('/datatables/datatable-blog',			'Backend\DatatableController@datatableBlog')->name('datatable-blog');
Route::get('/datatables/datatable-join-events',		'Backend\DatatableController@datatableJoinEvents')->name('datatable-join-events');
Route::get('/datatables/datatable-friends',			'Backend\DatatableController@datatableFriends')->name('datatable-friends');



//////////// end datatables //////////////////////////////


///////////// modale /////////////////////////////////
Route::get('/modale/{modal}/{dowhat}/{id}',			'Backend\ModaleController@generalModale')->name('general-modale');
//////////// end modale //////////////////////////////


///////////// test relationare /////////////////////////////////
Route::get('/test/has-one',							'Backend\TestController@hasOne')->name('test-has-one');
Route::get('/test/has-many',						'Backend\TestController@hasMany')->name('test-has-many');
//////////// end modale //////////////////////////////


Route::get('login/facebook', 						'SocialAuthFacebookController@redirect')->name('facebook-login');
Route::get('login/facebook/callback', 				'SocialAuthFacebookController@callback')->name('facebook-callback');



Route::get ('/test-mail',							'MailController@TestMail')->name('test-mail');
Route::post('/test-mail-post',						'MailController@TestMailPost')->name('test-mail-post');


Route::get ('/cron/update-user-status/',		    'CronController@updateUserStatus')->name('update-user-status');


// pagini vizibile daca esti logat
Auth::routes();





