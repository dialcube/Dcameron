<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Habitacion;

class DcameronController extends Controller
{
    public function index()
    {
        $hoteles = Hotel::with('habitaciones')->get();
        return response()->json($hoteles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'direccion' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255',
            'nit' => 'required|string|max:20|unique:hotels',
            'numero_habitaciones' => 'required|integer',
            'habitaciones' => 'required|array',
            'habitaciones.*.tipo' => 'required|string',
            'habitaciones.*.acomodacion' => 'required|string',
            'habitaciones.*.cantidad' => 'required|integer',
        ]);

        $hotel = Hotel::create($request->only(['nombre', 'direccion', 'ciudad', 'nit', 'numero_habitaciones']));

        $total_habitaciones = 0;
        foreach ($request->habitaciones as $habitacion) {
            if (!$this->validarAcomodacion($habitacion['tipo'], $habitacion['acomodacion'])) {
                return response()->json(['error' => "Acomodación inválida para el tipo de habitación {$habitacion['tipo']}."], 400);
            }

            $total_habitaciones += $habitacion['cantidad'];

            Habitacion::create([
                'hotel_id' => $hotel->id,
                'tipo' => $habitacion['tipo'],
                'acomodacion' => $habitacion['acomodacion'],
                'cantidad' => $habitacion['cantidad'],
            ]);
        }

        if ($total_habitaciones > $hotel->numero_habitaciones) {
            return response()->json(['error' => 'La cantidad de habitaciones configuradas supera el máximo por hotel.'], 400);
        }

        return response()->json($hotel->load('habitaciones'), 201);
    }

    private function validarAcomodacion($tipo, $acomodacion)
    {
        $validaciones = [
            "ESTANDAR" => ["SENCILLA", "DOBLE"],
            "JUNIOR" => ["TRIPLE", "CUADRUPLE"],
            "SUITE" => ["SENCILLA", "DOBLE", "TRIPLE"]
        ];
        return in_array($acomodacion, $validaciones[$tipo]);
    }
}
