<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSurvey extends Model
{
    use HasFactory;

    protected $table = 'master_survey';
    protected $fillable = ['pertanyaan'];

    public function feedbackSurveys()
    {
        return $this->hasMany(FeedbackSurvey::class, 'survey_id');
    }
}