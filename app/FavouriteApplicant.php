<?php

namespace App;

use App;
use Illuminate\Database\Eloquent\Model;

class FavouriteApplicant extends Model
{

    protected $table = 'favourite_applicants';
    public $timestamps = true;
    protected $guarded = ['id'];
    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
