<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    
        use HasFactory;
            // Specify the table name if it differs from the default (optional)
            protected $table = 'responses';
    
            // If you want to allow mass assignment, define fillable fields
            protected $fillable = ['survey_id', 'formatted_answers','user_id'];
    }
