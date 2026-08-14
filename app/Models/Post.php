<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Disable timestamps if you don't have created_at/updated_at columns
    public $timestamps = false;
    
    // Define fillable fields
    protected $fillable = ['title', 'slug', 'content', 'status'];
}