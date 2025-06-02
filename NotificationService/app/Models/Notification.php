<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'log_notificaciones';

    protected $fillable = [
        'tracking_id',
        'event_source_id',
        'event_type',
        'recipient_email',
        'subject',
        'template_used',
        'status',
        'sent_at',
        'processed_at',
        'attempts',
        'error_details'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'processed_at' => 'datetime',
        'attempts' => 'integer'
    ];
}
