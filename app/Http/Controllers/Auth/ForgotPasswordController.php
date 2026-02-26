<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

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
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        // Преобразуем ответ в русское сообщение
        $message = $this->getResetMessage($response);
        
        return back()
            ->withInput()
            ->withErrors(['email' => $message]);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('status', 'Ссылка для сброса пароля отправлена на ваш email!');
    }

    /**
     * Преобразовать ответ Password::broker в понятное сообщение
     */
    private function getResetMessage($response)
    {
        switch ($response) {
            case Password::INVALID_USER:
                return 'Пользователь с таким email не найден.';
            case Password::INVALID_TOKEN:
                return 'Неверный токен сброса пароля.';
            case Password::RESET_THROTTLED:
                return 'Слишком много попыток. Пожалуйста, попробуйте позже.';
            default:
                return 'Произошла ошибка при сбросе пароля.';
        }
    }
}
