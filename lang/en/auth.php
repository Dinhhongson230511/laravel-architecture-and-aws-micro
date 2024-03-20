<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'message' => [
        'login' => [
            'success' => 'Login successful.',
            'error' => 'Incorrect email or password.',
            'account_not_exist' => 'Account does not exist.',
        ],
        'logout' => [
            'success' => 'Logout successful.',
            'error' => 'Logout failed.'
        ],
        'reset_password' => [
            'error' => 'Refresh token has expired.',
            'success' => 'Password reset successful.',
            'send_mail_success' => 'Password reset request has been submitted successfully. Please check your email. If you have any questions or concerns, feel free to contact us.',
            'send_mail_error' => 'Failed to send email. Please try again.',
        ],
        'change_password' => [
            'error' => 'Failed to force password change.',
            'success' => 'Password change successful.'
        ]
    ],
];
