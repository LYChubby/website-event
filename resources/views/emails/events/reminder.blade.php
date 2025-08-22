@component('mail::message')
# Halo, {{ $user->name }}

Ini pengingat bahwa kamu telah membeli tiket untuk event:

**{{ $event->name_event }}**  
📅 Tanggal: {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}  
📍 Lokasi: {{ $event->venue_address }}

Event ini akan dimulai dalam **3 hari lagi**.  
Jangan lupa hadir ya! 🎉

@component('mail::button', ['url' => url('/events/'.$event->event_id)])
Lihat Detail Event
@endcomponent

Terima kasih,  
{{ config('app.name') }}
@endcomponent
