<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyReferral extends Model
{

    protected $fillable = ['company_id', 'code', 'is_used', 'used_by', 'name', 'email'];
    protected $guarded = ['id'];

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id', 'id');
    }

    public function usedBy()
    {
        return $this->belongsTo('App\User', 'used_by', 'id');
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

    public function scopeUnUsed($query)
    {
        return $query->where('is_used', '=', 0);
    }

    public function scopeUsed($query)
    {
        return $query->where('is_used', '=', 1);
    }

    public function getDisplayCodeAttribute(){
        return ($this->email == null && $this->name == null) ? $this->company->name . " - " . $this->company->email: $this->name . " - " . $this->email;
    }

}
