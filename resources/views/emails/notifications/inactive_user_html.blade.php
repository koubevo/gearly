<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <title>Chybíte nám na Gearly!</title>
</head>

<body style="background-color:#f4f4f4;font-family:Arial,sans-serif;margin:0;padding:20px;color:#000;">
    <div
        style="max-width:600px;margin:0 auto;background-color:#ffffff;border:2px solid #000000;box-shadow:0 5px 10px rgba(0,0,0,0.1);">

        <div
            style="background-color:#1D9E1D;padding:15px;display:flex;align-items:center;justify-content:space-between;">
            <h1 style="color:#fff;font-size:28px;margin:0;font-weight:bold;">Gearly</h1>
            <img src="https://gearly.eu/storage/imgs/short.png" alt="Gearly logo" style="height:40px;margin-left:20px;">
        </div>

        <div style="padding:20px;">
            <h2 style="font-weight:bold;font-size:24px;">Chybíš nám, {{ $user->name }}!</h2>
            <p style="font-size:16px;line-height:1.5;margin-top:10px;margin-bottom:10px;">Všimli jsme si, že jsi Gearly
                nenavštívil/a více než 10 dní.
                Máme pro tebe čerstvé nabídky vybavení na baseball a softball.</p>

            <div style="margin:30px 0;text-align:center;">
                <a href="https://gearly.eu?utm_source=email&utm_medium=notification&utm_campaign=inactive_user"
                    style="display:inline-block;background-color:#1D9E1D;color:#ffffff;text-decoration:none;padding:10px 20px;border:2px solid #000000;font-weight:bold;">
                    Zpátky na Gearly</a>
            </div>

            <p style="font-size:14px;color:#555555;">Těšíme se na tebe,<br>tým Gearly</p>
        </div>

        <div style="background-color:#000000;padding:10px;text-align:center;">
            <p style="color:#ffffff;font-size:12px;margin:0;">&copy; {{ date('Y') }} Gearly.eu - Baseball & Softball
                Bazar</p>
        </div>

    </div>

</body>

</html>