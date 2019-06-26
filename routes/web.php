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

Route::get('payment2/ticket/{folio}', 'Payment2Controller@TicketWeb');

Route::get('email/resp', 'Payment2Controller@resp');


Route::group(['middleware'=> 'loginIn'], function () {

	Route::get('/', function(Request $request){
		return view('index', ['request' => $request]);
	});

	Route::get('email', function (){

		try{
			Mail::send('emails.test', [],function($message){
				$message->from('no-reply@lololola.com.mx', 'SRE');
				$message->to(['samuel43_7@hotmail.com'])->subject('SRE');
			});
			
			echo "OK";
		} catch (\Excpetion $e){
			echo $e;
		}


	});


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

	
	Route::post('payment2/payment/finelize', 'Payment2Controller@FinelizeTicket');
	Route::post('payment2/payment/finalizedCheck', 'Payment2Controller@CheckFinalizedTicket');
	Route::post('payment2/payment/delete', 'Payment2Controller@DeletePayment');
	Route::post('payment2/payment/add', 'Payment2Controller@AddPayment');

	Route::post('payment2/upload_designs', 'Payment2Controller@UploadDesigns');
	Route::post('payment2/get_payment_list', 'Payment2Controller@GetPaymentList');
	Route::post('payment2/charge', 'Payment2Controller@MakeCharge');
	Route::post('payment2/get_client', 'Payment2Controller@GetClient');
	Route::get('payment2/list', 'Payment2Controller@lists');
	Route::resource('payment2', 'Payment2Controller');

	//Route::resource('payment2', 'Payment2Controller');

});

