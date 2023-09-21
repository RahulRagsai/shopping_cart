<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('test', function () {
    $adminPermission =Permission::create(['name' => 'HomeController@index']);
    $b2cPermisssion = Permission::create(['name' => 'HomeController@B2C']);
    $adminRole = Role::find(1);
    $adminRole->givePermissionTo($adminPermission);
    $b2cRole = Role::find(2);
    $b2cRole->givePermissionTo($b2cPermisssion);
    $user = User::find(1);
    $user->assignRole('admin');
});
Route::post('checkout', 'Stripe\StripeController@checkout')->name('checkout');
Route::get('success', 'Stripe\StripeController@success');

Auth::routes();
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('B2C', 'HomeController@B2C');
    
});

