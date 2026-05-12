<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Vetly OTP</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f7fb; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0"
        style="background-color:#f4f7fb; padding:40px 0;">

        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0" border="0"
                    style="background-color:#ffffff; border-radius:12px; overflow:hidden; box-shadow:0 2px 10px rgba(0,0,0,0.08);">

                    {{-- Header --}}
                    <tr>
                        <td align="center"
                            style="background-color:#2D8CFF; padding:30px; color:white;">

                            <h1 style="margin:0; font-size:32px;">
                                Vetly
                            </h1>

                            <p style="margin-top:10px; font-size:16px;">
                                Password Reset Verification
                            </p>

                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:40px; color:#333333;">

                            <h2 style="margin-top:0;">
                                Hello 👋
                            </h2>

                            <p style="font-size:16px; line-height:28px;">
                                We received a request to reset your password for your
                                Vetly account.
                            </p>

                            <p style="font-size:16px; line-height:28px;">
                                Use the verification code below to continue:
                            </p>

                            {{-- OTP --}}
                            <div style="text-align:center; margin:35px 0;">

                                <span
                                    style="
                                        display:inline-block;
                                        background-color:#f3f6fb;
                                        color:#2D8CFF;
                                        font-size:36px;
                                        font-weight:bold;
                                        letter-spacing:10px;
                                        padding:20px 35px;
                                        border-radius:12px;
                                    ">
                                    {{ $otp }}
                                </span>

                            </div>

                            <p style="font-size:15px; color:#666666;">
                                This code will expire in <strong>1 minute</strong>.
                            </p>

                            <p style="font-size:15px; color:#666666; line-height:26px;">
                                If you did not request a password reset, please ignore this email.
                            </p>

                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center"
                            style="padding:25px; background-color:#f9fafc; color:#999999; font-size:13px;">

                            © {{ date('Y') }} Vetly. All rights reserved.

                        </td>
                    </tr>

                </table>

            </td>
        </tr>

    </table>

</body>

</html>