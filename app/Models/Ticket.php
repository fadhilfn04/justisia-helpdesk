<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'category_id', 'assigned_to',
        'title', 'description', 'status', 'priority'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function agent()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'category_id');
    }

    public function messages()
    {
        return $this->hasMany(TicketMessage::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(TicketStatusLog::class);
    }

    public function timelines()
    {
        return $this->hasMany(TicketTimeline::class);
    }

    public function feedbackSurveys()
    {
        return $this->hasMany(FeedbackSurvey::class);
    }
}