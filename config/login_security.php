<?php

return [
    'max_attempts' => env('LOGIN_MAX_ATTEMPTS', 5),
    'lockout_duration' => env('LOGIN_LOCKOUT_DURATION', 5), // minutes
    'attempt_window' => env('LOGIN_ATTEMPT_WINDOW', 15), // minutes
    'notify_on_lockout' => env('LOGIN_NOTIFY_ON_LOCKOUT', true),
];
