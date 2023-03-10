<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'date_end' => 'datetime',
    ];

    static $statuses = [
        'PENDING', 'RECEIVED', 'CONFIRMED', 'OVERDUE', 'REFUNDED', 'PAID'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'invoice_id', 'id');

    }



}
