<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nuevo mensaje de contacto</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 20px; }
        .content { background: white; padding: 20px; border: 1px solid #dee2e6; border-radius: 8px; }
        .footer { margin-top: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; font-size: 14px; color: #666; }
        .field { margin-bottom: 15px; }
        .label { font-weight: bold; color: #495057; }
        .message-box { background: #f8f9fa; padding: 15px; border-left: 4px solid #007bff; margin: 15px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin: 0; color: #007bff;">📧 Nuevo mensaje de contacto</h2>
            <p style="margin: 5px 0 0 0; color: #666;">Recibiste un mensaje a través de tu portfolio</p>
        </div>

        <div class="content">
            <div class="field">
                <span class="label">👤 De:</span> {{ $contactMessage->sender_name }}
            </div>

            <div class="field">
                <span class="label">✉️ Email:</span>
                <a href="mailto:{{ $contactMessage->sender_email }}">{{ $contactMessage->sender_email }}</a>
            </div>

            @if($contactMessage->subject)
            <div class="field">
                <span class="label">📋 Asunto:</span> {{ $contactMessage->subject }}
            </div>
            @endif

            <div class="field">
                <span class="label">💬 Mensaje:</span>
                <div class="message-box">
                    {!! nl2br(e($contactMessage->message)) !!}
                </div>
            </div>
        </div>

        <div class="footer">
            <p><strong>💡 Tip:</strong> Podés responder directamente a este email para contactar a {{ $contactMessage->sender_name }}.</p>
            <p style="margin: 10px 0 0 0;">
                Enviado desde <strong>{{ config('app.name', 'Sitio Fotógrafos') }}</strong><br>
                <small>{{ now()->format('d/m/Y H:i') }}</small>
            </p>
        </div>
    </div>
</body>
</html>