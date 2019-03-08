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
use App\Http\Requests;
use Illuminate\Http\Request;

Route::group(['namespace'=>'Auth'], function () {
	Route::get('login', 'LoginController@index');
	Route::post('login', 'LoginController@auth');
	Route::get('logout', 'LoginController@logout');
});

Route::get('index', function () {
	if( \Auth::check() ){
		return redirect('/');
	} else { 
		return redirect('login');
	}
});

Route::get('citas/publico', 'DatingController@MakeDatingIndexPublic');
Route::post('citas/get_public_citas', 'DatingController@GetPublicCitas');
Route::post('citas/save_public_cita', 'DatingController@SavePublicCita');

Route::group(['middleware'=> 'loginIn'], function () {

	Route::get('/', function(Request $request){
		return view('index', ['request' => $request]);
	});

	Route::get('citas/list', 'DatingController@CitasListView');
	Route::post('citas/save_cita', 'DatingController@SaveCita');
	Route::post('citas/get_citas', 'DatingController@GetCitas');
	Route::get('citas', 'DatingController@MakeDatingIndex');
	
	Route::post('dating/delete_exception_date', 'DatingController@DeleteExceptionDate');
	Route::post('dating/add_exception', 'DatingController@AddException');
	Route::post('dating/delete_slot', 'DatingController@DeleteSlot');
	Route::post('dating/get_schedules', 'DatingController@GetSchedules');
	Route::post('dating/list', 'DatingController@list');
	Route::resource('dating', 'DatingController');

	Route::post('user/list', 'UserController@lists');
	Route::post('user/search', 'UserController@search');
	Route::post('user/actdes', 'UserController@actdes');
	Route::post('user/reset_password', 'UserController@ResetPassword');
	Route::resource('user', 'UserController');

	Route::post('product/check_stock', 'ProductController@CheckStock');
	Route::post('product/list', 'ProductController@lists');
	Route::resource('product', 'ProductController');

	Route::post('service/list', 'ServiceController@lists');
	Route::resource('service', 'ServiceController');

	Route::post('payment2/get_payment_list', 'Payment2Controller@GetPaymentList');
	Route::post('payment2/charge', 'Payment2Controller@MakeCharge');
	Route::post('payment2/get_client', 'Payment2Controller@GetClient');
	Route::get('payment2/list', 'Payment2Controller@lists');
	Route::resource('payment2', 'Payment2Controller');

	//Route::resource('payment2', 'Payment2Controller');
});

