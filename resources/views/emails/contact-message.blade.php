@component('mail::message')
# Nuevo mensaje de contacto

Recibiste un mensaje a través de tu portfolio.

**De:** {{ $contactMessage->sender_name }}
**Email:** {{ $contactMessage->sender_email }}
@if($contactMessage->subject)
**Asunto:** {{ $contactMessage->subject }}
@endif

---

{{ $contactMessage->message }}

---

*Podés responder directamente a este email para contactar a {{ $contactMessage->sender_name }}.*

Gracias,<br>
{{ config('app.name') }}
@endcomponent
