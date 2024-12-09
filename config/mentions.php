<?php

return [
    'pools' => [
        'users' => [
            // Model that will be mentioned.
            'model' => App\Models\User::class,

            // The column that will be used to search the model by the parser.
            'column' => 'email',

            // The route used to generate the user link.
            'route' => '/profile/@',

            // Notification class to use when this model is mentioned.
            'notification' => App\Notifications\MentionNotif::class,
        ]
    ]
];
