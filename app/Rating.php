<?php

namespace App;

use App\Traits\Active;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating extends Model
{
    use Active, SoftDeletes;

    protected $table = 'ratings';
    protected $fillable = ['title', 'stars', 'is_active'];
}
