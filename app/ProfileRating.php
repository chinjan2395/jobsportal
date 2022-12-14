<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileRating extends Model
{

    protected $fillable = ['user_id', 'rating_id', 'reason', 'company_id'];
    protected $guarded = ['id'];
    protected $appends = [];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function rating()
    {
        return $this->belongsTo('App\Rating', 'rating_id', 'id');
    }

    public function getRating($field = '')
    {
        if (null !== $model = $this->rating()->first()) {
            if (empty($field))
                return $model;
            else
                return $model->$field;
        } else {
            return '';
        }
    }

    public function getUser($field = '')
    {
        if (null !== $user = $this->user()->first()) {
            if (empty($field))
                return $user;
            else
                return $user->$field;
        } else {
            return '';
        }
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id', 'id');
    }

    public function getCompany($field = '')
    {
        if (null !== $company = $this->company()->first()) {
            if (!empty($field)) {
                return $company->$field;
            } else {
                return $company;
            }
        }
    }

}
