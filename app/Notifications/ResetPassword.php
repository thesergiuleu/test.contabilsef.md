<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class ResetPassword extends \Illuminate\Auth\Notifications\ResetPassword
{
    use Queueable;

    /**
     * Build the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable, $this->token);
        }

        if (static::$createUrlCallback) {
            $url = call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        } else {
            $url = env("FRONTEND_APP_URL") . '#reset-password?token=' . $this->token . 'email=' . $notifiable->getEmailForPasswordReset();
        }

        return (new MailMessage)
            ->subject(Lang::get('Email pentru resetarea parolei'))
            ->line(Lang::get('Ați primit acest e-mail deoarece am primit o solicitare de resetare a parolei pentru contul dvs.'))
            ->action(Lang::get('Reseteaza parola'), $url)
            ->line(Lang::get('Acest link de resetare a parolei va expira în :count minute.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]))
            ->line(Lang::get('Dacă nu ați solicitat resetarea parolei, nu este necesară nicio altă acțiune.'));
    }

}
