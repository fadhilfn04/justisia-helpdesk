<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketStatusLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ticket_id', 'changed_by', 'old_status', 'new_status', 'note'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}