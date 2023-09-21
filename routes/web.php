<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Artisan;
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

Route::get('spatie', function () {
    Role::create(['name' => 'admin']);
    Role::create(['name' => 'B2C']);
    Role::create(['name' => 'B2B']);
    $adminPermission =Permission::create(['name' => 'HomeController@index']);
    $b2cPermisssion = Permission::create(['name' => 'HomeController@B2C']);
    $b2bPermisssion = Permission::create(['name' => 'HomeController@B2B']);
    $adminRole = Role::find(1);
    $adminRole->givePermissionTo($adminPermission);
    $b2cRole = Role::find(2);
    $b2cRole->givePermissionTo($b2cPermisssion);
    $b2bPermisssion = Permission::find(3);
    $b2bRole = Role::find(3);
    $b2bRole->givePermissionTo($b2bPermisssion);
    $user = User::find(1);
    $user->assignRole('admin');
    try {
        Artisan::call('cache:forget', ['key' => 'spatie.permission.cache']);
        $output = Artisan::output();
        
        if (strpos($output, 'Cache cleared successfully') !== false) {
            return 'Cache cleared successfully';
        } else {
            return $output;
        }
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});
Route::post('checkout', 'Stripe\StripeController@checkout')->name('checkout');
Route::get('success', 'Stripe\StripeController@success');

Auth::routes();
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('B2C', 'HomeController@B2C');
    Route::get('B2B', 'HomeController@B2B');
    Route::get('revoke', 'HomeController@revoke')->name('revoke');
    Route::get('refund', 'Stripe\StripeController@refund')->name('refund');
});

