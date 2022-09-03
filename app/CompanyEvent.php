<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyEvent extends Model
{

    protected $fillable = ['company_id', 'title', 'description', 'start_date', 'end_date', 'slug'];
    protected $guarded = ['id'];

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
