<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeedbackAndEnquiry extends Model
{
    protected $table = 'feedback_and_enquiries';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];
}
