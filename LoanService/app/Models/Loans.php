<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loans extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_libro',
        'loan_date',
        'f_devolucion_establecida',
        'f_devolucion_real',
        'estado'
    ];  
}
