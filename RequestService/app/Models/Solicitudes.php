<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Solicitudes extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'id_usuario',
        'id_libro',
        'estado',
        'fecha_de_registro'
    ]; 
}
