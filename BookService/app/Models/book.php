<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class book extends Model
{
     use HasFactory;

    protected $table = 'book';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'titulo',
        'id_autor',
        'anio_publicacion',
        'estado',
    ];

    // Si quieres proteger contra otros atributos no deseados
    protected $guarded = ['id'];

    // Casts para formatos específicos
    protected $casts = [
        'anio_publicacion' => 'integer',
    ];

}
