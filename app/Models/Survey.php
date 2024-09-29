<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_name',
        'questions',
        'question_type',
        'options',
        'user_id'
        
    ];

    protected $casts = [
        'questions' => 'array',
    ];
}
