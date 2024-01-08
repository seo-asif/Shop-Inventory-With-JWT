<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function loginPage(): View
    {
        return view('pages.auth.login-page');
    }

    public function registrationPage(): View
    {
        return view('pages.auth.registration-page');
    }

    public function sendOtpPage(): View
    {
        return view('pages.auth.send-otp-page');
    }

    public function verifyOTPPage(): View
    {
        return view('pages.auth.verify-otp-page');
    }

    public function resetpasswordPage(): View
    {
        return view('pages.auth.reset-pass-page');
    }

    public function profilePage(): View
    {
        return view('pages.dashboard.profile-page');
    }

    public function registration(Request $request)
    {

        try {
            $validate = $request->validate([
                "name"     => 'required | string | min:4 | max:50',
                "email"    => 'required | email',
                "password" => 'required | string',
            ]);

            User::create($request->input());
            return response()->json([
                'status' => 'success',
                'msg'    => 'Registration successful',
            ], );
        } catch (Exception $error) {
            return response()->json([
                'status' => 'failed',
                'msg'    => 'Registration Failed',
                'reason' => $error->getMessage(),
            ], );
        }
    }

    public function login(Request $request)
    {

        try {
            $count = User::where('email', $request->input('email'))->where('password', $request->input('password'))->first();

            if ($count !== null) {
                $token = JWTToken::createToken($request->input('email'), $count->id);
                return response()->json([
                    'status' => 'success',
                    'msg'    => "login successful",
                    'token'  => $token,
                ], )->cookie('token', $token, 60 * 24 * 30, "/");
            } else {
                return response()->json([
                    'status' => 'failed',
                    'msg'    => "Invalid email or password",
                ], );

            }
        } catch (Exception $error) {
            return response()->json([
                'status' => 'failed',
                'msg'    => "Invalid email or password",
                'reason' => $error->getMessage(),
            ], );
        }
    }

    public function sendOTPCode(Request $request)
    {
        try {
            $email = $request->input('email');
            $otp = rand(2500, 9999);

            $count = User::where('email', $email)->count();
            if ($count == 1) {
                Mail::to($email)->send(new OTPMail($otp));
                User::where('email', $email)->update(['otp' => $otp]);

                return response()->json([
                    'status' => 'success',
                    'msg'    => 'OTP send successfully',
                    'otp'    => $otp,

                ], );
            } else {
                return response()->json([
                    'status' => 'failed',
                    'msg'    => 'User with the provided email not found.',
                ], );
            }
        } catch (Exception $error) {
            return response()->json([
                'status' => 'failed',
                'msg'    => 'OTP send Failed',
                'reason' => $error->getMessage(),
            ], );
        }
    }

    public function verifyOTPCode(Request $request)
    {
        $email = $request->input('email');
        $otp = $request->input('otp');

        // Check if the OTP is valid and hasn't expired
        $user = User::where('email', $email)->where('otp', $otp)->first();

        if ($user && !$this->isOTPOutdated($user->updated_at)) {
            // Mark the OTP as used
            USER::where('email', $email)->update(['otp' => "0"]);

            // Generate a token for setting the password
            $token = JWTToken::createTokenForSetPassword($email);

            return response()->json([
                'status' => 'success',
                'msg'    => 'Verify token successful',
                'token'  => $token,
            ], 200)->cookie('token', $token, 60 * 24 * 30);

        } else {
            return response()->json([
                'status' => 'failed',
                'msg'    => 'Verification token failed',
            ], );
        }
    }

// Helper function to check if OTP is outdated
    private function isOTPOutdated($updatedAt)
    {
        $expirationTime = Carbon::parse($updatedAt)->addMinutes(5);
        return now()->gt($expirationTime);
    }

    public function resetPassword(Request $request)
    {

        try {
            $email = $request->header('email');
            $password = $request->input('password');

            USER::where('email', $email)->update(['password' => $password]);
            return response()->json([
                'status'   => 'success',
                'msg'      => 'Password Reset Successful',
                'password' => $password,
            ], 200);

        } catch (Exception $error) {
            return response()->json([
                'status' => 'failed',
                'msg'    => 'Password Reset failed',
                'reason' => $error->getMessage(),
            ], 500);
        }
    }

    public function userLogout()
    {
        return redirect("/login")->cookie('token', "", -1);
    }

    public function userProfile(Request $request)
    {
        $id = $request->header('id');
        $user = User::where('id', $id)->first();
        return response()->json([
            'status' => 'success',
            'msg'    => 'Request Successful',
            'data'   => $user,
        ], 200);
    }

    public function updateProfile(Request $request)
    {
        try {
            $id = $request->header('id');
            $name = $request->input('name');

            User::where('id', $id)->update([
                'name' => $name,

            ]);
            return response()->json([
                'status' => 'success',
                'msg'    => 'Request Successful',
            ], 200);

        } catch (Exception $exception) {
            return response()->json([
                'status' => 'fail',
                'msg'    => 'Something Went Wrong',
            ], 200);
        }
    }

}
