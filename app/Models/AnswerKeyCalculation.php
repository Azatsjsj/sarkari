<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerKeyCalculation extends Model
{
    use HasFactory;

    protected $table = 'answer_key_calculations';

    protected $fillable = [
        'answer_key_url',
        'category',
        'horizontal_reservation',
        'gender',
        'state',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'positive_marks',
        'negative_marks',
        'net_score',
        'normalized_score',
        'overall_rank',
        'category_rank',
        'state_rank',
        'percentile',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'total_questions' => 'integer',
        'correct_answers' => 'integer',
        'wrong_answers' => 'integer',
        'positive_marks' => 'float',
        'negative_marks' => 'float',
        'net_score' => 'float',
        'normalized_score' => 'float',
        'overall_rank' => 'integer',
        'category_rank' => 'integer',
        'state_rank' => 'integer',
        'percentile' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
