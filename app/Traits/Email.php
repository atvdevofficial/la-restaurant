<?php

namespace App\Traits;

trait Email
{
    public function sendEmail($template, $templateData, $subject)
    {
        $toName = env('MAIL_TO_NAME', 'template');
        $toEmail = env('MAIL_TO_EMAIL', 'template@template.com');

        return \Mail::send($template, $templateData, function ($message) use ($toName, $toEmail, $subject) {
            $message->to($toEmail, $toName);
            $message->subject($subject);
        });
    }
}
