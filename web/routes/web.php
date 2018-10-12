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

// Route::get('/', 'WeatherStationController@login');

// Route::get('/test', function(){
//     $db = App::make('aws')->createClient('dynamodb');
//     $result = $db->scan([
//         'TableName' => 'WeatherStation'
//     ]);
//     $items = $result['Items'];
//     dd(json_decode($items[0]['sensor_data']['S'], true));
// });

Route::get('/', 'WeatherStationController@pressure');
Route::get('/pressure', 'WeatherStationController@pressure');
Route::get('/pressure.json', 'WeatherStationController@getPressure');

Route::get('/humidity', 'WeatherStationController@humidity');
Route::get('/humidity.json', 'WeatherStationController@getHumidity');

Route::get('/temperature', 'WeatherStationController@temperature');
Route::get('/temperature.json', 'WeatherStationController@getTemperature');

Route::get('/calendar', 'WeatherStationController@calendar');
Route::get('/intruder', 'WeatherStationController@intruder');

Route::get('/logout', function() {
    Auth::logout();
    return redirect('/login');
});

Route::get('/register', 'app.RegisterController@create');

Auth::routes();