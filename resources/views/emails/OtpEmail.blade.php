<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>OTP Email</title>
<style>
    /* Reset styles */
    body, table, td, a {
        font-family: Arial, sans-serif;
        font-size: 16px;
        line-height: 1.6;
        margin: 0;
        padding: 0;
        border: 0;
        color: #333;
    }

    /* Container styles */
    .container {
        max-width: 600px;
        margin: 0 auto;
    }

    /* Header styles */
    .header {
        background-color: #202940;
        padding: 20px 0;
        text-align: center;
    }

    /* Logo styles */
    .logo {
        max-width: 250px;
        height: auto;
    }

    /* Content styles */
    .content {
        background-color: #ffff;
        padding: 40px;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }

    .otp {
        font-size: 32px;
        margin-bottom: 20px;
        letter-spacing: 7px;
    }

    .info {
        margin-bottom: 20px;
    }

    /* Footer styles */
    .footer {
        background-color: #f6f6f6;
        padding: 20px 0;
        text-align: center;
    }

    .footer a {
        color: #0049ff;
        text-decoration: none;
    }
</style>
</head>
<body>
<table class="container" border="0" align="center" width="100%">
    <tr>
        <td class="header">
            <img src="{{ asset('/assets/logo/logo-1.png')}}" alt="Logo" class="logo">
        </td>
    </tr>
    <tr>
        <td class="content">
            <h2 style="color: #0049ff; font-size: 24px; margin-bottom: 20px;">Your One-Time Password (OTP)</h2>
            <p class="otp"><strong>{{ $data[0]->opt }}</strong></p>
            <p class="info">This is a One Time Password (OTP) that will expire after 2 minutes.</p>
        </td>
    </tr>
    <tr>
        <td class="footer">
            <p>If you did not request this OTP, please ignore this email.</p>
            <!-- <p>For assistance, contact <a href="mailto:support@example.com">support@example.com</a></p> -->
        </td>
    </tr>
</table>
</body>
</html>
