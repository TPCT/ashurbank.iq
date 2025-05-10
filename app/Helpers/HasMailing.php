<?php

namespace App\Helpers;

use App\Mail\WebformNotify;
use Illuminate\Support\Facades\Mail;

trait HasMailing
{
    public static function send_email($model, $to, $subject){
        $to = explode(',', $to);
        foreach ($to as $email) {
            try{
                Mail::to($email)->send(new WebformNotify($model, $subject));
            }catch (\Exception $e){
                dd($e->getMessage());
                continue;
            }
        }
    }

    public static function bootHasMailing(){
        parent::saving(function($model){
            self::send_email($model, $model->mailing_to, $model->mailing_subject);
        });
    }

}