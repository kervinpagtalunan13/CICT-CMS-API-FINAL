<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Mail\ResetPasswordEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if ($request->user()->status == 'i')
                return response()->json(['message' => 'account is not available'], 401);

            $authorize = [
                'reviewer' => ['can_approve_revision', 'can_comment'],

                'admin' => ['can_create_user', 'can_add_subject', 'can_create_curriculum', 'can_submit_revision'],

                'faculty' => ['can_add_subject', 'can_create_curriculum', 'can_submit_revision'],

                'chair' => ['can_add_subject', 'can_create_curriculum', 'can_submit_revision'],
            ];

            $token = $request->user()->createToken('auth-token', $authorize[$request->user()->role])->plainTextToken;
            $user = User::where('id', $request->user()->id)->with('profile')->first();
            return response()->json(['token' => $token, 'message' => 'login succesfully', 'user' => $user]);
        }

        return response()->json(['message' => 'Invalid email or password'], 401);
    }

    public function register(RegisterUserRequest $request)
    {
        $user = User::create([
            'password' => bcrypt($request->password),
            'email' => $request->email,
            'role' => $request->role,
            'department_id' => $request->departmentId,
        ]);
        return response()->json(['message' => 'user registration success', 'user' => $user]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getuser(Request $request)
    {
        $user = auth()->user();
        $user = User::where('id', $user->id)->with('profile', 'department')->first();
        return response()->json($user);
    }


    // C:\Users\kyed\Desktop\Accenture Project\cict-cms-api-v2\public
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // $existingRequest = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        // if ($existingRequest) {
        //     // Email is already in the password reset table
        //     return response()->json(['message' => 'Password reset email has already been sent.'], 400);
        // }

        $response = Password::sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Password reset email sent.'], 200)
            : response()->json(['message' => 'Failed to send password reset email.'], 400);
        return;

        // $request->validate(['email' => 'required|email']);

        // $status = Password::sendResetLink(
        //     $request->only('email')
        // );

        // return $status === Password::RESET_LINK_SENT
        //     ? response()->json(['message' => 'Password reset email sent.'], 200)
        //     : response()->json(['message' => 'Failed to send password reset email.'], 400);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => 'password reset succesfully.'], 200)
            : response()->json(['message' => 'failed to reset the password.'], 400);
    }

    public function broker()
    {
        return Password::broker();
    }
}
    
    // public function forgetPassword(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'email' => 'required|email',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['message' => 'Invalid email'], 400);
    //     }

    //     $email = $request->input('email');
    //     $user = User::where('email', $email)->first();

    //     if (!$user) {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }

    //     $code = Str::random(6);
    //     DB::table('password_reset_tokens')->insert([
    //         'email' => $email,
    //         'token' => $code,
    //         'created_at' => now()
    //     ]);

    //     Mail::to($user->email)->send(new ResetPasswordEmail($code));

    //     return response()->json(['message' => 'Code sent to email']);
    // }