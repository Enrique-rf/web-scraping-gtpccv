<?php

use App\Http\Controllers\VehiculoController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('welcome');
})->name('home');*/

Route::get('/token', [VehiculoController::class, 'obtenerToken'])->name('vehiculo.token');

Route::get('/recorrido', [VehiculoController::class, 'mostrarRecorrido'])->name('vehiculos.recorrido');

Route::get('/prueba', function () {
    $response = Http::withToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzUxMiJ9.eyJ1c3VhcmlvIjoibWNhYnJhbCIsImNvZF9jbGllbnRlIjozMzEsImV4cCI6MTc0ODU0NjY1NDY1OX0.P1mw5MZxy4dU-TKreX9qONioA6S9sm-HrhkYBAo2tmmNya8MdR5NzOT0DVClNmQwIGpeOxo5LYm0oUauu0HTiw')
        ->get('https://gtpmovil.com/apirastreo/v1/clientes/control-flota/datos-utiles/3773');

    return $response->json();
});

Route::get('/vehiculos', [VehiculoController::class, 'index']);
Route::get('/vehiculos/create', [VehiculoController::class, 'create'])->name('vehiculos.create');
Route::post('/vehiculos', [VehiculoController::class, 'store'])->name('vehiculos.store');