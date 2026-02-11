<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;

    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    public function build()
    {
        return $this->subject('Nuevo mensaje de contacto: ' . ($this->contactMessage->subject ?: 'Sin asunto'))
                    ->replyTo($this->contactMessage->sender_email, $this->contactMessage->sender_name)
                    ->markdown('emails.contact-message');
    }
}
