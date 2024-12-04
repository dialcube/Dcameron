<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model

{

    use HasFactory;

    /**

     * Nombre de la tabla en la base de datos

     */

    protected $table = 'hotels'; // Tabla en plural

    /**

     * Atributos asignables masivamente

     */

    protected $fillable = [

        'nombre',

        'direccion',

        'ciudad',

        'nit',

        'numero_habitaciones',

    ];

    /**

     * Relación con el modelo Habitacion

     */

    public function habitaciones()

    {

        return $this->hasMany(Habitacion::class, 'hotel_id');

    }

}

