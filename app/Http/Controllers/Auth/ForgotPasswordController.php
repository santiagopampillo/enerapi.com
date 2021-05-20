<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request['email'] = $request['reset_email'];
        $this->validateEmail($request);

        if( $user = Registered::where('email', $request->input('email') )->first() )
        {
            $token = str_random(64);

            DB::table('password_resets')->insert([
                'email' => $user->email, 
                'token' => $token
            ]);

            $user->sendPasswordResetNotification($token);

            return  $this->sendResetLinkResponse(null);
        }

        return $this->sendResetLinkFailedResponse($request,null);
        
    }

    protected function sendResetLinkFailedResponse(Request $request, $response)
    {

        $responseArray['success'] = true;
        $responseArray["data"]["rePass"] = 2;
        $responseArray["data"]["message"] = "No encontramos socios con ese e-mail";
       
        return $responseArray;
    }

    protected function sendResetLinkResponse($response)
    {
        
        $responseArray['success'] = true;
        $responseArray["data"]["rePass"] = 1;
        $responseArray["data"]["message"] = "Te mandamos un mail para que puedas resetear tu contraeña!";
        return $responseArray;
    }
}
