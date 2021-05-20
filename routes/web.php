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

Route::get('reset_password/{token}', ['as' => 'password.reset', function($token)
{
    // implement your reset password route here!
}]);

Route::get('/', function () {
    return redirect('docs/');
});

Route::get('process/pozos', 'PozosController@index');
Route::get('pozos/procesarDatos', 'PozosController@procesarDatos');
Route::get('pozos/bajarArchivos', 'PozosController@bajarArchivos');


Route::prefix('admin')->group(function () {
	Route::get('/login','Admin\Auth\LoginController@showLoginForm')->name('admin.login');
	Route::get('/logout','Admin\Auth\LoginController@logout')->name('admin.logout');
	Route::post('/login','Admin\Auth\LoginController@login')->name('admin.login.submit');
	Route::get('/password/reset/{token}','Admin\Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('/password/reset','Admin\Auth\ResetPasswordController@reset')->name('admin.reset.post');
	Route::get('/password/email','Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.email');
	Route::post('/password/email','Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.email.post');
	Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');

    Route::middleware(['auth:admin'])->group(function () {

		Route::resource('users', 'Admin\UserController');
		Route::resource('empresas', 'Admin\EmpresaController');
		Route::resource('usuarios_api', 'Admin\UsuarioApiController');
        Route::resource('datosDdjj', 'Admin\DatoDdjjController');
        Route::resource('proceso_bajar_archivos', 'Admin\ProcesamientoArchivoController');
        Route::resource('proceso_procesar_archivos', 'Admin\ProcesamientoController');
        Route::get('datosDdjj/view/{id?}', 'Admin\DatoDdjjController@view')->name('datosDdjj.view');
                           
        Route::get('/users/export', 'Admin\UserController@export')->name('users.export');                
        Route::get('/users/change_pass/{id?}', 'Admin\UserController@change_pass')->name('users.change_pass');    

            
	});

    
	
});