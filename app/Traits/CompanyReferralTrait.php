<?php


namespace App\Traits;

use App\Http\Requests\ReferralFormRequest;
use App\CompanyReferral;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;


trait CompanyReferralTrait
{
    public function referrals(Request $request)
    {
        $company = Auth::guard('company')->user();
        $referrals = [
            'un_used' => $company->referrals()->with('usedBy')->unUsed()->paginate(10),
            'used' => $company->referrals()->with('usedBy')->used()->paginate(10)
        ];
        return view('company.referrals')->with('referrals', $referrals);
    }

    public function storeFrontReferral(ReferralFormRequest $request)
    {
        $company = Auth::guard('company')->user();

        if ((bool)$company->is_active === false) {
            flash(__('Your account is inactive contact site admin to activate it'))->error();
            return Redirect::route('company.home');
        }

        $model = new CompanyReferral();
        $model->company_id = $company->id;
//        $model->code = Str::uuid();
        $model->code = $request->get('code');
        $model->save();

        flash('Referral has been added!')->success();

        return Redirect::route('posted.referrals');

    }

    public function deleteReferral(Request $request)
    {
        $id = $request->input('id');
        try {
            $model = CompanyReferral::findOrFail($id);
            $model->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }

    }
}
