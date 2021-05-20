<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('front.registro_reset_pass')->with(
            ['token' => $token, 'email' => $request->email]
            );
    }

    public function reset(\Illuminate\Http\Request $request)
    {
        $pw_reset = \DB::table('password_resets')->where('token', $request->get('token'))->first();

        if ($pw_reset)
        {
            \Request::merge(['email' => $pw_reset->email]);
        }
        else
        {
            \Request::merge(['email' => 'noemail@noemail.com']);   
        }                
       
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        if( $user = Registered::where('email', $request->input('email') )->first() )
        {
            $this->resetPassword($user, $request->input('password'));
            \DB::table('password_resets')->where('token', $request->get('token'))->delete();
            return $this->sendResetResponse(null);
        }
        else
        {
            return $this->sendResetFailedResponse($request, null);
        }
    }

    protected function resetPassword($user, $password)
    {
        $user->password = bcrypt($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        //event(new PasswordReset($user));

        //$this->guard()->login($user);
    }


    protected function sendResetFailedResponse(Request $request, $response)
    {

        $responseArray['success'] = true;
        $responseArray["data"]["createPass"] = 3;
        $responseArray["data"]["message"] = "No se pudo recuperar la contraseña, volver a resetear la contraseña para un nuevo intento";
       
        return $responseArray;
    }

    protected function sendResetResponse($response)
    {
        $responseArray['success'] = true;
        $responseArray["data"]["createPass"] = 1;
        $responseArray["data"]["message"] = "Tu nueva contraseña fue actualizada.";
        return $responseArray;
    }   
}
