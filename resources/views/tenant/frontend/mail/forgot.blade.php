<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f6f9fc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="100%" max-width="600px"
                    style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); padding: 30px;">
                    <tr>
                        <td align="center" style="padding-bottom: 20px;">
                            <h2 style="color: #2c3e50;">Reset Your Password</h2>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p style="color: #555; font-size: 16px;">
                                Hello <strong>{{ $mailData['name'] }}</strong>,
                            </p>
                            <p style="color: #555; font-size: 16px;">
                                We received a request to reset your password for your account. Use the verification code
                                below to proceed:
                            </p>
                            <div style="margin: 30px 0; text-align: center;">
                                <span
                                    style="font-size: 28px; font-weight: bold; color: #4e73df; letter-spacing: 4px;">{{ $mailData['verification_code'] }}</span>
                            </div>
                            <p style="color: #555; font-size: 15px;">
                                If you didn’t request a password reset, you can safely ignore this email. The code will
                                expire soon for your security.
                            </p>
                            <p style="color: #555; font-size: 15px; margin-top: 30px;">
                                Regards,<br>
                                <strong>{{ config('app.name') }} Team</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-top: 30px; font-size: 12px; color: #999;">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>