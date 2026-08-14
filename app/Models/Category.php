<?php
// app/Models/Category.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'is_active'];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}