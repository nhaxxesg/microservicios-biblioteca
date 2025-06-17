<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'mensaje',
        'fecha',
        'leida'
    ];

    /**
     * Los atributos que deben convertirse a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha' => 'datetime',
        'leida' => 'boolean',
    ];

    /**
     * Obtener usuario relacionado con la notificación.
     * 
     * Nota: Este método está aquí para documentación, pero la implementación
     * real dependería de cómo se gestiona la comunicación entre microservicios.
     */
    public function user()
    {
        // En un monolito usaríamos una relación directa:
        // return $this->belongsTo(User::class);
        
        // En microservicios, tendríamos que hacer una llamada a la API del UserService
    }
}
