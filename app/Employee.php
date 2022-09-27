<?php


namespace App;

use Illuminate\Database\Eloquent\Builder;

class Employee extends Company
{
    protected $table = 'companies';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $builder->where('is_employee', '=', true);
        });
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'belongs_to', 'id');
    }

    public function referrals()
    {
        return $this->hasMany('App\CompanyReferral', 'company_id');
    }
}

