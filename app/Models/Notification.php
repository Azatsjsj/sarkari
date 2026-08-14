<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'type',
        'title',
        'message',
        'link',
        'icon',
        'is_read',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function sendJobNotification($job)
    {
        return self::create([
            'type' => 'job',
            'title' => 'New Job Alert: ' . $job->title,
            'message' => 'Latest recruitment update for ' . ($job->organization ?? $job->title) . '. Check application details!',
            'link' => route('job.show', $job->slug),
            'icon' => 'fa-briefcase text-primary',
            'is_read' => false,
        ]);
    }

    public static function sendResultNotification($result)
    {
        return self::create([
            'type' => 'result',
            'title' => 'New Result Declared: ' . $result->title,
            'message' => 'Official result list published. Check your roll number and merit status now!',
            'link' => route('results.show', $result->slug),
            'icon' => 'fa-chart-bar text-success',
            'is_read' => false,
        ]);
    }

    public static function sendAdmitCardNotification($admitCard)
    {
        return self::create([
            'type' => 'admit_card',
            'title' => 'Admit Card Released: ' . $admitCard->title,
            'message' => 'Hall ticket download link is live. Download your exam admit card now!',
            'link' => route('admit-card.show', $admitCard->slug),
            'icon' => 'fa-ticket-alt text-warning',
            'is_read' => false,
        ]);
    }

    public static function sendAnswerKeyNotification($answerKey)
    {
        return self::create([
            'type' => 'answer_key',
            'title' => 'Answer Key Out: ' . $answerKey->title,
            'message' => 'Official candidate answer key and objection link published!',
            'link' => route('answer-key.show', $answerKey->slug),
            'icon' => 'fa-key text-danger',
            'is_read' => false,
        ]);
    }

    public static function sendAdmissionNotification($admission)
    {
        return self::create([
            'type' => 'admission',
            'title' => 'New Admission Notice: ' . $admission->title,
            'message' => 'Application form open for ' . ($admission->university->name ?? $admission->title) . '!',
            'link' => route('admissions.show', $admission->slug),
            'icon' => 'fa-graduation-cap text-info',
            'is_read' => false,
        ]);
    }
}
