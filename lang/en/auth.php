<?php

declare(strict_types=1);

return [
    'login' => [
        'title' => 'Sign in to your account',
        'subtitle' => 'Enter your credentials to access',
        'email' => 'Email address',
        'email_placeholder' => 'example@email.com',
        'password' => 'Password',
        'password_placeholder' => '••••••••',
        'remember' => 'Remember me',
        'submit' => 'Sign in',
        'forgot_password' => 'Forgot your password?',
        'no_account' => 'Don\'t have an account?',
        'register' => 'Sign up',
    ],

    'register' => [
        'title' => 'Create a new account',
        'subtitle' => 'Enter your details to register',
        'name' => 'Full name',
        'name_placeholder' => 'John Doe',
        'email' => 'Email address',
        'email_placeholder' => 'example@email.com',
        'password' => 'Password',
        'password_placeholder' => '••••••••',
        'password_confirmation' => 'Confirm password',
        'password_confirmation_placeholder' => '••••••••',
        'submit' => 'Sign up',
        'already_registered' => 'Already have an account? Sign in',
    ],

    'forgot-password' => [
        'title' => 'Reset your password',
        'subtitle' => 'Enter your email to receive the reset link',
        'email' => 'Email address',
        'email_placeholder' => 'example@email.com',
        'submit' => 'Send reset link',
        'back_to_login' => 'Back to login',
    ],

    'reset-password' => [
        'title' => 'Reset password',
        'subtitle' => 'Enter your new password',
        'email' => 'Email address',
        'email_placeholder' => 'example@email.com',
        'password' => 'New password',
        'password_placeholder' => '••••••••',
        'password_confirmation' => 'Confirm password',
        'password_confirmation_placeholder' => '••••••••',
        'submit' => 'Reset password',
    ],

    'passwords' => [
        'reset' => 'Your password has been reset!',
        'sent' => 'We have emailed your password reset link!',
        'throttled' => 'Please wait before retrying.',
        'token' => 'This password reset token is invalid.',
        'user' => 'We can\'t find a user with that email address.',
    ],

    'login-via' => 'Or log in via',

    'login-failed' => 'Login failed, please try again.',

    'user-not-allowed' => 'Your email is not part of a domain that is allowed.',

    'registration-not-enabled' => 'Registration of a new user is not allowed.',

    'login-in' => 'Sign in',
    'sign-up' => 'Sign up',
];
