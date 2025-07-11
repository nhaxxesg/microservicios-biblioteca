<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibroCategorias extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'libro_id',
        'id_categoria',
    ];
    public $timestamps = false;
    public function libro()
    {
        return $this->belongsTo(Book::class, 'libro_id');
    }
}
