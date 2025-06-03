<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title>Tvoje nabídka byla vyzvednuta!</title>
</head>

<body style="background-color:#f4f4f4;font-family:Arial,sans-serif;margin:0;padding:0;">
    <div
        style="max-width:600px;margin:0 auto;background-color:#ffffff;border:2px solid #000000;box-shadow:0 5px 10px rgba(0,0,0,0.1);">

        <div style="background-color:#1D9E1D;padding:15px;display:flex;align-items:center;">
            <h1 style="color:#ffffff;font-size:24px;margin:0;font-weight:bold;">Gearly</h1>
        </div>

        <div style="padding:24px; color: #000;">
            <p style="font-size:16px;margin-bottom:20px;">
                Ahoj,<br><br>
                uživatel <strong>{{ $senderName }}</strong> právě vyzvedl nabídku
                <strong>{{ $offerName }}</strong>. Nyní můžeš tohoto uživatele ohodnotit.
            </p>

            <div style="text-align:center;margin:32px 0;">
                <a href="{{ $chatUrl }}"
                    style="background-color:#1D9E1D;color:#ffffff;padding:10px 20px;border:2px solid #000000;text-decoration:none;font-weight:bold;display:inline-block;">
                    Ohodnotit uživatele v chatu
                </a>
            </div>

            <p style="font-size:14px;color:#000;"><br>tým Gearly<br><a href="https://gearly.eu"
                    style="color:#1D9E1D;text-decoration:none;">gearly.eu</a></p>
        </div>

        <div style="background-color:#000000;padding:12px;text-align:center;">
            <p style="color:#ffffff;font-size:12px;margin:0;">
                © {{ date('Y') }} Gearly.eu – Baseball & Softball Bazar
            </p>
            <p style="color:#ffffff;font-size:12px;margin:8px 0 0;">
                Nechceš dostávat e-mailová upozornění? Změň to v <a href="{{ route('profile.show') }}"
                    style="color:#1D9E1D;text-decoration:underline;">nastavení profilu</a>.
            </p>
        </div>

    </div>
</body>

</html>