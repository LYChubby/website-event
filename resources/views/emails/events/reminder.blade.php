<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reminder Event - {{ $event->name_event }}</title>
</head>

<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, Helvetica, sans-serif;">

    <!-- Main Container -->
    <table cellpadding="0" cellspacing="0" width="100%" style="background-color: #f4f4f4; min-height: 100vh;">
        <tr>
            <td align="center" style="padding: 20px 0;">

                <!-- Email Content -->
                <table cellpadding="0" cellspacing="0" width="600" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); overflow: hidden;">

                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 30px 40px; text-align: center;">
                            <h1 style="color: #ffffff; font-size: 28px; font-weight: bold; margin: 0; text-shadow: 0 2px 4px rgba(0,0,0,0.3);">
                                🎊 Reminder Event
                            </h1>
                        </td>
                    </tr>

                    <!-- Greeting Section -->
                    <tr>
                        <td style="padding: 30px 40px 20px;">
                            <h2 style="color: #333333; font-size: 24px; margin: 0 0 15px; font-weight: 600;">
                                Halo, {{ $user->name }}! 👋
                            </h2>
                            <p style="color: #666666; font-size: 16px; line-height: 1.6; margin: 0;">
                                Ini pengingat bahwa kamu telah membeli tiket untuk event yang sangat ditunggu-tunggu:
                            </p>
                        </td>
                    </tr>

                    <!-- Event Card -->
                    <tr>
                        <td style="padding: 0 40px 20px;">
                            <table cellpadding="0" cellspacing="0" width="100%" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; overflow: hidden;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <h3 style="color: #ffffff; font-size: 22px; font-weight: bold; margin: 0 0 15px; text-shadow: 0 1px 3px rgba(0,0,0,0.3);">
                                            {{ $event->name_event }}
                                        </h3>

                                        <!-- Event Details -->
                                        <table cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td style="padding: 8px 0; vertical-align: top;">
                                                    <span style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; display: inline-block; width: 20px;">📅</span>
                                                    <span style="color: #ffffff; font-size: 16px; font-weight: 500;">
                                                        {{ \Carbon\Carbon::parse($event->start_date)->translatedFormat('d F Y') }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 8px 0; vertical-align: top;">
                                                    <span style="color: rgba(255,255,255,0.9); font-size: 14px; font-weight: 600; display: inline-block; width: 20px;">📍</span>
                                                    <span style="color: #ffffff; font-size: 16px; font-weight: 500;">
                                                        {{ $event->venue_address }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Countdown Message -->
                    <tr>
                        <td style="padding: 0 40px 25px;">
                            @php
                            if ($day > 0) {
                            $message = "Event ini akan dimulai dalam **{$day} hari lagi**. Persiapkan dirimu untuk pengalaman yang tak terlupakan! 🚀";
                            $bgColor = "#e3f2fd";
                            $textColor = "#1976d2";
                            $icon = "⏰";
                            } else {
                            $message = "Hari ini adalah **Hari-H** event! Jangan lupa hadir ya dan nikmati setiap momennya! 🎉";
                            $bgColor = "#fff3e0";
                            $textColor = "#f57c00";
                            $icon = "🔥";
                            }
                            @endphp

                            <table cellpadding="0" cellspacing="0" width="100%" style="background-color: '{{ $bgColor }}'; border-radius: 8px; border-left: 4px solid '{{ $textColor }}';">
                                <tr>
                                    <td style="padding: 20px 25px;">
                                        <p style="color: '{{ $textColor }}'; font-size: 18px; font-weight: 600; margin: 0; text-align: center;">
                                            {{ $icon }} {!! str_replace('**', '<strong>', str_replace('**', '</strong>', $message)) !!}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- CTA Button -->
                    <tr>
                        <td style="padding: 0 40px 30px; text-align: center;">
                            <table cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                <tr>
                                    <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50px; padding: 15px 35px; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                        <a href="{{ url('/events/'.$event->event_id) }}" style="color: #ffffff; font-size: 16px; font-weight: bold; text-decoration: none; display: inline-block; text-transform: uppercase; letter-spacing: 1px;">
                                            🎫 Lihat Detail Event
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Additional Info -->
                    <tr>
                        <td style="padding: 0 40px 30px;">
                            <table cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8f9fa; border-radius: 8px;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <h4 style="color: #495057; font-size: 16px; margin: 0 0 10px; font-weight: 600;">
                                            💡 Tips untuk Event:
                                        </h4>
                                        <ul style="color: #6c757d; font-size: 14px; line-height: 1.6; margin: 0; padding-left: 20px;">
                                            <li>Datang 15-30 menit sebelum acara dimulai</li>
                                            <li>Bawa tiket digital atau cetak tiketmu</li>
                                            <li>Ikuti protokol yang berlaku di venue</li>
                                            <li>Jangan lupa charge gadgetmu untuk foto-foto keren! 📸</li>
                                        </ul>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #2c3e50; padding: 25px 40px; text-align: center;">
                            <p style="color: #ecf0f1; font-size: 16px; margin: 0 0 10px; font-weight: 500;">
                                Terima kasih telah mempercayai kami! 🙏
                            </p>
                            <p style="color: #bdc3c7; font-size: 14px; margin: 0;">
                                Salam hangat,<br>
                                <strong style="color: #3498db;">{{ config('app.name') }}</strong>
                            </p>

                            <!-- Social Media Links (Optional) -->
                            <table cellpadding="0" cellspacing="0" style="margin: 20px auto 0;">
                                <tr>
                                    <td style="padding: 0 10px;">
                                        <a href="#" style="color: #3498db; font-size: 12px; text-decoration: none;">
                                            📧 Email
                                        </a>
                                    </td>
                                    <td style="padding: 0 10px;">
                                        <a href="#" style="color: #3498db; font-size: 12px; text-decoration: none;">
                                            📱 WhatsApp
                                        </a>
                                    </td>
                                    <td style="padding: 0 10px;">
                                        <a href="#" style="color: #3498db; font-size: 12px; text-decoration: none;">
                                            🌐 Website
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>

                <!-- Footer Note -->
                <table cellpadding="0" cellspacing="0" width="600" style="max-width: 600px; margin-top: 20px;">
                    <tr>
                        <td style="text-align: center; padding: 0 20px;">
                            <p style="color: #999999; font-size: 12px; line-height: 1.4; margin: 0;">
                                Email ini dikirim otomatis. Jika kamu memiliki pertanyaan, silakan hubungi customer service kami.
                                <br>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

</body>

</html>