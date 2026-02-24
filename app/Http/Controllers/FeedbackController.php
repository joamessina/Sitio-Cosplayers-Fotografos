<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class FeedbackController extends Controller
{
    public function create()
    {
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        // Rate limiting: 3 por IP cada 10 minutos
        $key = 'feedback:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()
                ->withInput()
                ->withErrors(['rate_limit' => "Demasiados envíos. Esperá {$seconds} segundos."]);
        }
        RateLimiter::hit($key, 600);

        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'email', 'max:150'],
            'type'    => ['required', 'in:suggestion,bug,other'],
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'name.required'    => 'El nombre es obligatorio',
            'email.required'   => 'El email es obligatorio',
            'email.email'      => 'El email no es válido',
            'type.required'    => 'Seleccioná un tipo',
            'type.in'          => 'Tipo inválido',
            'message.required' => 'El mensaje es obligatorio',
            'message.min'      => 'El mensaje debe tener al menos 10 caracteres',
            'message.max'      => 'El mensaje no puede superar los 2000 caracteres',
        ]);

        $feedback = Feedback::create([
            'user_id' => auth()->id(),
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'type'    => $validated['type'],
            'message' => $validated['message'],
            'ip'      => $request->ip(),
        ]);

        // Enviar notificación por email al admin
        $adminEmail = env('ADMIN_EMAIL', env('MAIL_FROM_ADDRESS', 'onboarding@resend.dev'));
        $typeLabel  = $feedback->typeLabel();

        try {
            $resend = \Resend::client(env('RESEND_API_KEY'));
            $resend->emails->send([
                'from'    => 'Cosplay AR <onboarding@resend.dev>',
                'to'      => [$adminEmail],
                'subject' => "[Feedback] {$typeLabel}: " . \Illuminate\Support\Str::limit($validated['message'], 60),
                'html'    => "
                    <h2>Nuevo feedback recibido</h2>
                    <p><strong>Tipo:</strong> {$typeLabel}</p>
                    <p><strong>De:</strong> {$validated['name']} ({$validated['email']})</p>
                    " . (auth()->check() ? "<p><strong>Usuario:</strong> " . auth()->user()->name . " (ID " . auth()->id() . ")</p>" : "<p><em>Usuario no registrado</em></p>") . "
                    <hr>
                    <p>" . nl2br(e($validated['message'])) . "</p>
                ",
            ]);
        } catch (\Exception $e) {
            \Log::error('Error enviando email de feedback: ' . $e->getMessage());
        }

        return redirect()
            ->route('feedback.create')
            ->with('status', '¡Gracias por tu feedback! Lo revisamos pronto.');
    }
}
