<?php

namespace App\Console\Commands;

use App\Models\Vehiculo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ActualizarKmRecorridos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Vehiculos:actualizar-km-recorridos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Actualizar los kilómetros recorridos de los vehículos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /*$tokenData = Cache::remember('token', now()->addHours(6), function () {
                $response = Http::post('https://gtpmovil.com/apirastreo/v1/auth/login', [
                    'name' => 'mcabral',
                    'clave' => 'mtaller',
                ]);

                return $response->json();
            });
             $token = $tokenData['token'] ?? null;
            if (!$token) {
                return 'Error al obtener el token';
            }

        $vehiculos = Vehiculo::all();
          foreach ($vehiculos as $vehiculo) {
            $response = Http::withToken($token)
                ->get("https://gtpmovil.com/apirastreo/v1/clientes/control-flota/datos-utiles/{$vehiculo->vehiculo_id}");
            if ($response->successful()) {
                $data = $response->json();
                $odometroTotal = $data['odometroTotal']??null;

                $vehiculo->km_recorridos = $odometroTotal - $vehiculo->km_inicial;
                $vehiculo->save();
          }
        }*/
        $this->info("⏳ Iniciando actualización de kilómetros...");

    $tokenData = Cache::remember('token', now()->addHours(6), function () {
        $response = Http::post('https://gtpmovil.com/apirastreo/v1/auth/login', [
            'name' => 'mcabral',
            'clave' => 'mtaller',
        ]);

        return $response->json();
    });

    $token = $tokenData['token'] ?? null;
    if (!$token) {
        $this->error('❌ Error al obtener el token');
        return Command::FAILURE;
    }

    $vehiculos = Vehiculo::all();

    foreach ($vehiculos as $vehiculo) {
        $response = Http::withToken($token)
            ->get("https://gtpmovil.com/apirastreo/v1/clientes/control-flota/datos-utiles/{$vehiculo->vehiculo_id}");

        if ($response->successful()) {
            $data = $response->json();
            $odometroTotal = $data['odometroTotal'] ?? null;

            if ($odometroTotal === null) {
                $this->warn("⚠ Vehículo ID {$vehiculo->id}: odómetro no disponible.");
                continue;
            }

            $vehiculo->km_recorridos = $odometroTotal - $vehiculo->km_inicial;
            $vehiculo->save();

            $this->info("✔ Vehículo ID {$vehiculo->id}: KM recorridos actualizados.");
        } else {
            $this->error(" Error en la API para vehículo ID {$vehiculo->id}");
        }
    }

    $this->info("✅ Actualización finalizada.");
    return Command::SUCCESS;
    }
}
