<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class VehiculoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function obtenerToken()
    {
        return Cache::remember('token', now()->addHours(6), function () {
           $response = Http::post(config('services.gtp.url') . '/auth/login', [
            'name' => config('services.gtp.username'),
            'clave' => config('services.gtp.password'),
        ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }
            return 'No se pudo obtener el token';
        });
    }

    public function obtenerOdometro($vehiculoId)
    {
        $tokenData = $this->obtenerToken();
        $token = $tokenData['token'] ?? null;
        if(!$token)
        {
            return 'Error al obtener el token';
        }
        $response = Http::withToken($token)
            ->get("https://gtpmovil.com/apirastreo/v1/clientes/control-flota/datos-utiles/{$vehiculoId}");
        if ($response->successful()) {
            $data = $response->json();
            return $data['odometroTotal']??null;
        }
        return null;
        
    }

    public function index()
    {
        $vehiculos = Vehiculo::all();
        return view('vehiculos', compact('vehiculos'));
    }

     public function create()
    {
        return view('vehiculosCreate'); // Retorna la vista con el formulario
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'vehiculo_id' => 'required|integer',
            'nombre' => 'required|string|max:255',
            'matricula' => 'required|string|max:255',
            'km_real' => 'required|numeric',
            'km_recorridos' => 'required|numeric',
        ]);

        Vehiculo::create([
            'vehiculo_id' => $request->vehiculo_id,
            'nombre' => $request->nombre,
            'matricula' => $request->matricula,
            'km_inicial' => 0,
            'km_real' => $request->km_real,
            'km_recorridos' => $request->km_recorridos,
        ]);

        $odometro = $this->obtenerOdometro($request->vehiculo_id);
        if ($odometro !== null) {
            Vehiculo::where('vehiculo_id', $request->vehiculo_id)
                ->update(['km_inicial' => $odometro /1000]); // Dividir por 1000 para convertir a km
        } else {
            return redirect()->back()->withErrors(['error' => 'No se pudo obtener el odómetro del vehículo.']);
        }

        return redirect('/vehiculos')->with('success', 'Vehículo creado exitosamente.');
    }
        
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
