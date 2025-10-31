<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackSurvey extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id', 'user_id', 'survey_id',
        'nilai', 'comment', 'sent_via'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function survey()
    {
        return $this->belongsTo(MasterSurvey::class, 'survey_id');
    }
}