<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $resetUrl;
    public $token;

    /**
     * Create a new message instance.
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
        // Use APP_URL from config to ensure it works on other devices
        $baseUrl = rtrim(config('app.url'), '/');
        $this->resetUrl = $baseUrl . '/password/reset/' . $token;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Password Reset Request - TOAI HRM')
                    ->view('emails.password-reset')
                    ->with([
                        'user' => $this->user,
                        'resetUrl' => $this->resetUrl,
                        'token' => $this->token,
                    ]);
    }
}

