<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterSurvey extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'master_survey';
    protected $fillable = ['pertanyaan'];

    public function feedbackSurveys()
    {
        return $this->hasMany(FeedbackSurvey::class, 'survey_id');
    }
}