<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WebformNotify extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public ?Model $model = null;
    public function __construct($model, $subject)
    {
        $this->model = $model;
        $this->subject = $subject;
    }


    public function build(): WebformNotify
    {
        $attributes = $this->model->attributesToArray();
        foreach ($this->model->upload_attributes ?? [] as $attribute)
            $attributes[$attribute] = asset('/storage/forms/' . $attributes[$attribute]);
        foreach ($attributes as $attribute => $value){
            if (str_ends_with($attribute, "_id")){
                unset($attributes[$attribute]);
            }
        }
        return $this->view('Mails.webform-notify')->with([
            'data' => \Arr::except($attributes, [
                'created_at',
                'updated_at',
                'id',
            ])
        ]);
    }

}
