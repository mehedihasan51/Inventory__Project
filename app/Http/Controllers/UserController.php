<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Mail\OTPMail;
use App\Helper\JWTToken;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    function LoginPage():View{

        return view('pages.auth.login-page');
    }
    function RegistrationPage():View{

        return view('pages.auth.registration-page');
    }
    function SendOtpPage():View{

        return view('pages.auth.send-otp-page');
    }
    function VerifyOTPPage():View{

        return view('pages.auth.verify-otp-page');
    }
    function ResetPasswordPage():View{

        return view('pages.auth.reset-pass-page');
    }
    function ProfilePage():View{

        return view('pages.dashboard.profile-page');
    }
    function DashboardPage():View{

        return view('pages.dashboard.dashboard-page');
    }


    function UserRegistration(Request $request){

        try{

            User::create([
                'firstName'=> $request->input('firstName'),
                'lastName'=> $request->input('lastName'),
                'email'=> $request->input('email'),
                'mobile'=> $request->input('mobile'),
                'password'=> $request->input('password'),
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'User Registration Successfully'
            ],200);

        }
        catch(Exception $e){

            return response()->json([
                'status' => 'failed',
                'message' => 'User Registration failed'
            ]);
        }
      
    }

    function UserLogin(Request $request){

      $count =  User::where('email','=',$request->input('email'))
        ->where('password','=',$request->input('password'))
        ->select('id')->first();

        if($count!==null){

            //User Login->JWT token isssue

            $token=JWTToken::CreateToken($request->input('email'),$count->id);
            
            return response()->json([
                'status'=> 'Successful',
                'message'=>'User Login Successful',
                
            ],200)->cookie('token',$token,60*24*30);
        }
        else{

            return response()->json([
                'status'=> 'failed',
                'message'=>'unauthorized'
            ],200);

        }
    }


    function SendOTPCode(Request $request){

        $email=$request->input('email');
        $otp = rand(1000,9999);
        $count=User::where('email','=',$email)->count();

        if($count==1){

            //OTP Email Address

            Mail::to($email)->send(new OTPMail($otp));
            //OTP Code Table Update
            $count=User::where('email','=',$email)->update(['otp'=>$otp]);

            return response()->json([
                'status'=>'Success',
                'message'=>'4 Digit OTP Code has been send to your email !'
            ]);

        }
        else{
            return response()->json([
                'status'=>'failed',
                'message'=>'unauthorized'
            ]);
        }
    }


    function VerifyOTP(Request $request){
        $email=$request->input('email');
        $otp=$request->input('otp');
        $count=User::where('email','=',$email)->where('otp','=',$otp)->count();

        if($count==1){

            //DataBase OTP Update

            $count=User::where('email','=',$email)->update(['otp'=>'0']);

            //pass Reset token issue

            $token=JWTToken::CreateTokenForSetPassword($request->input('email'));
            
            return response()->json([
                'status'=> 'Successful',
                'message'=>'OTP Verification Successful',
                
            ],200)->cookie('token',$token,60*24*38);
        }else{
            return response()->json([
                'status'=>'failed',
                'message'=>'unauthorized'
            ]);
        }
    }

    function ResetPassword(Request $request){

        try{
            $email=$request->header('email');

            $password=$request->input('password');
     
            User::where('email','=',$email)->update(['password'=>$password]);

            return response()->json([
                'status'=> 'Successfull',
                'message'=>'Request Successfull'
            ]);

        }catch(Exception $exception){

            return response()->json([
                'status'=> 'failed',
                'message'=>'Something Went Wrong'
            ]);

        }

      
    }

    function UserLogout(){
        return redirect('/userLogin')->cookie('token','',-1);
    }

    function UserProfile(Request $request){
        $email=$request->header('email');
        $user=User::where('email','=',$email)->first();
        return response()->json([
            'status' => 'success',
            'message' => 'Request Successful',
            'data' => $user
        ],200);
    }

    function UpdateProfile(Request $request){
        try{
            $email=$request->header('email');
            $firstName=$request->input('firstName');
            $lastName=$request->input('lastName');
            $mobile=$request->input('mobile');
            $password=$request->input('password');
            User::where('email','=',$email)->update([
                'firstName'=>$firstName,
                'lastName'=>$lastName,
                'mobile'=>$mobile,
                'password'=>$password
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Request Successful',
            ],200);
        }catch(Exception $exception){

            return response()->json([
                'status' => 'fail',
                'message' => 'Something Went Wrong',
            ],200);
        }
    }
}
