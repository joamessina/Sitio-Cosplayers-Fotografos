<?php

namespace App\Mail;

use Illuminate\Mail\Transport\Transport;
use Resend;
use Swift_Mime_SimpleMessage;

class ResendTransport extends Transport
{
    protected $client;

    public function __construct()
    {
        $this->client = Resend::client(config('services.resend.key'));
    }

    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        $this->beforeSendPerformed($message);

        $to = collect($message->getTo())->keys()->first();
        
        $data = [
            'from' => config('mail.from.address'),
            'to' => $to,
            'subject' => $message->getSubject(),
            'html' => $message->getBody(),
        ];

        $this->client->emails->send($data);

        $this->sendPerformed($message);

        return $this->numberOfRecipients($message);
    }
}