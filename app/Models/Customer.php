<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;


    // En lugar de ser el modelo de la tabla "productos" será de la tabla "mis_productos"
    protected $table = "customes";
    
    // Cambiamos la clave primaria al campo "nuevo_producto_id"
    protected $primaryKey = "nuevo_producto_id";
}
