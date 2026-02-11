<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ContactController extends Controller
{
    public function store(Request $request, User $user)
    {
        // Rate limiting: 3 mensajes por IP cada 10 minutos
        $key = 'contact-message:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = ceil($seconds / 60);

            return back()
                ->withInput()
                ->withErrors(['rate_limit' => "Enviaste demasiados mensajes. Podés intentar de nuevo en {$minutes} minuto(s)."]);
        }

        $validated = $request->validate([
            'sender_name' => ['required', 'string', 'max:255'],
            'sender_email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'sender_name.required' => 'Tu nombre es obligatorio.',
            'sender_name.max' => 'El nombre no puede superar los 255 caracteres.',
            'sender_email.required' => 'Tu email es obligatorio.',
            'sender_email.email' => 'Ingresá un email válido.',
            'sender_email.max' => 'El email no puede superar los 255 caracteres.',
            'subject.max' => 'El asunto no puede superar los 255 caracteres.',
            'message.required' => 'El mensaje es obligatorio.',
            'message.max' => 'El mensaje no puede superar los 2000 caracteres.',
        ]);

        $contactMessage = ContactMessage::create([
            'recipient_id' => $user->id,
            'sender_name' => $validated['sender_name'],
            'sender_email' => $validated['sender_email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'sender_ip' => $request->ip(),
        ]);

        RateLimiter::hit($key, 600); // 600 segundos = 10 minutos

        // Enviar email usando API de Resend directamente
        try {
            $resend = \Resend::client(env('RESEND_API_KEY'));

            $resend->emails->send([
                'from' => 'onboarding@resend.dev',
                'to' => [$user->email],
                'subject' => 'Nuevo mensaje de contacto: ' . ($contactMessage->subject ?: 'Sin asunto'),
                'html' => view('emails.contact-message', compact('contactMessage'))->render(),
                'reply_to' => $contactMessage->sender_email,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error enviando email de contacto: ' . $e->getMessage());
            // DEBUG: Mostrar el error real
            return back()->withInput()->withErrors(['mail_error' => 'Error de mail: ' . $e->getMessage()]);
        }

        return back()->with('contact_sent', 'Tu mensaje fue enviado correctamente.');
    }
}
