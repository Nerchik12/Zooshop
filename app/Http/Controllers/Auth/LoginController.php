<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'phone';
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function attemptLogin(Request $request)
    {
        // Проверяем существует ли пользователь с таким номером телефона
        $userModel = config('auth.providers.users.model');
        $user = $userModel::where($this->username(), $request->input($this->username()))->first();
        
        if (!$user) {
            // Пользователь не найден
            throw ValidationException::withMessages([
                $this->username() => ['Аккаунт с таким номером телефона не найден. Пожалуйста, зарегистрируйтесь.'],
            ]);
        }
        
        // Пользователь найден, пробуем проверить пароль
        $credentials = [
            'phone' => $request->input('phone'),
            'password' => $request->input('password')
        ];
        
        $attempt = Auth::attempt(
            $credentials, 
            $request->boolean('remember')
        );
        
        if (!$attempt) {
            // Пароль неверный
            throw ValidationException::withMessages([
                'password' => ['Неверный пароль. Попробуйте ещё раз или восстановите доступ.'],
            ]);
        }
        
        return $attempt;
    }
}
