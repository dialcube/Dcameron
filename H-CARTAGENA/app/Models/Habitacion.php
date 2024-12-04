<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model

{

    use HasFactory;

    /**

     * Nombre de la tabla en la base de datos

     */

    protected $table = 'habitaciones'; // Tabla en plural

    /**

     * Atributos asignables masivamente

     */

    protected $fillable = [

        'hotel_id',

        'tipo',

        'acomodacion',

        'cantidad',

    ];

    /**

     * Relación con el modelo Hotel

     */

    public function hotel()

    {

        return $this->belongsTo(Hotel::class, 'hotel_id');

    }

}

 