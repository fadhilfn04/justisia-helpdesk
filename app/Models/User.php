<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'phone'
    ];

    protected $hidden = ['password'];

    // === Relationships ===
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }

    public function assignedTickets()
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function categoryAgents()
    {
        return $this->hasMany(CategoryAgent::class);
    }

    public function ticketMessages()
    {
        return $this->hasMany(TicketMessage::class, 'sender_id');
    }

    public function ticketStatusLogs()
    {
        return $this->hasMany(TicketStatusLog::class, 'changed_by');
    }

    public function ticketTimeline()
    {
        return $this->hasMany(TicketTimeline::class, 'actor_id');
    }

    public function feedbackSurveys()
    {
        return $this->hasMany(FeedbackSurvey::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }
}