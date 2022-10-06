<?php

namespace App\Http\Controllers\Auth;

use App\CompanyReferral;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\RegistersUsers;
use Jrean\UserVerification\Traits\VerifiesUsers;
use Jrean\UserVerification\Facades\UserVerification;
use App\Http\Requests\Front\UserFrontRegisterFormRequest;
use Illuminate\Auth\Events\Registered;
use App\Events\UserRegistered;

class RegisterController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;
    use VerifiesUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getVerification', 'getVerificationError']]);
    }

    public function register(UserFrontRegisterFormRequest $request)
    {
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->is_active = 0;
        $user->verified = 0;
        $user->save();
        /*         * *********************** */
        $user->name = $user->getName();
        $user->update();
        /*         * *********************** */
        /* Referral Code * *********************** */
        if ($request->input('referral_code') != null || $request->input('referral_code') != "") {
            $referral_code = CompanyReferral::where('code', '=', $request->input('referral_code'))
                ->where('is_used', '=', 0)
                ->get();
            if ($referral_code->count() > 0) {
                $referral_code = $referral_code->first();
                $referral_code->used_by = $user->id;
                $referral_code->is_used = 1;
                $referral_code->update();
            } else {
                $user->delete();
                return Redirect::back()
                    ->withInput($request->all())
                    ->withErrors(['referral_code' => 'Referral Code not found']);
            }
        }
        /* Referral Code * *********************** */
        event(new Registered($user));
//        event(new UserRegistered($user));
        $this->guard()->login($user);
        UserVerification::generate($user);
        UserVerification::send($user, 'User Verification', 'csr_notification@massar.com', 'CSR Notification');
        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }

}
