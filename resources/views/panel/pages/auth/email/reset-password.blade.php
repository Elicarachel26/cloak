<table style="font-family: 'Arial',sans-serif;color: #555;margin: 0 auto;width: 600px;font-size: 14px;">
    <tbody>
        <tr>
            <td>
                <div>
                    <h1 style="color: #808080;font-size: 24px;display: block;font-weight: bold;border-bottom-width: 1px;border-bottom-color: #e8e8e8;border-bottom-style: solid;margin: 0 0 20px;padding: 0;"
                        align="left">Reset Password<br>&nbsp;</h1>
                </div>
                <div>
                    <p style="margin: 0 0 20px;padding: 0;">Hi, {{ $user->name }}!</p>
                    <p style="margin: 0 0 20px;padding: 0;">We received a request to reset your password.</p>
                    <p style="margin: 0 0 20px;padding: 0;">
                        <a href="{{ url('reset-password/' . $token) .'?email='.$user->email }}"
                            style="color: #fff;text-decoration: none;display: inline-block;background-color: #337ab7;border-color: #2e6da4;border-radius: 4px;border-width: 0;padding: 6px 12px;font-size: 14px;line-height: 1.42857143;cursor: pointer;text-align: center;white-space: nowrap;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;">Reset
                            Password</a>
                    </p>
                    <p style="margin: 0 0 20px;padding: 0;">if you did not request a password reset, please ignore this
                        email.</p>
                    <p style="margin: 0 0 20px;padding: 0;">Thanks.</p>
                </div>
            </td>
        </tr>
    </tbody>
</table>