<?php

use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

if(!function_exists('email_temp')){
    function email_temp($name){
        return EmailTemplate::where('name', $name)->first();
    }
}

if (!function_exists('send_email')) {

    /**
     * Common email sender function
     *
     * @param string $to
     * @param string $templateName
     * @param array  $data
     * @return void
     */
    function send_email(string $to, string $templateName, array $data = [])
    {
        Mail::to($to)->send(
            new OtpMail($templateName, $data)
        );
    }
}