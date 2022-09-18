<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyEvent extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'title', 'description', 'start_date', 'end_date', 'slug', 'status'];
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

    public function scopeIsActive($query)
    {
        return $query->where('status', 1);
    }

}
