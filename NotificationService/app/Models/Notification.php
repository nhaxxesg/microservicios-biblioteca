<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Notification extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'user_id',
        'mensaje',
        'f_envio',
        'f_visto',
        'tipo',
        'estado'
    ];
}
