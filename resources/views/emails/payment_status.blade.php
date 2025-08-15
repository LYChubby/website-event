@component('mail::message')
# Halo {{ $transaction->user->name }}

Pembayaran untuk event **{{ $transaction->event->name }}** Anda berstatus **{{ ucfirst($status) }}**.

@component('mail::panel')
No Invoice: **{{ $transaction->no_invoice }}**  
Total: **Rp{{ number_format($transaction->total_price, 0, ',', '.') }}**
@endcomponent

Terima kasih telah menggunakan layanan kami.

Salam,  
**Tim Event**
@endcomponent
