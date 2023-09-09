<?php

return [
    'abandoned_challenges_deadline' => 3, // Three days
    'hope_bot_mail' => 'bot@hope.com',

    'achievements' => [
        1 => [
            'id' => 1,
            'name' => 'hopeful',
            'description' => 'The user earns this after starting a challenge',
            'score' => 5,
            'after_n_days' => 0,
        ],
        [
            'id' => 2,
            'name' => 'honored',
            'description' => 'The user earns this after five days of endurance in the challenge',
            'score' => 10,
            'after_n_days' => 5,
        ],
        [
            'id' => 3,
            'name' => 'diligent',
            'description' => 'The user earns this after ten days of endurance in the challenge',
            'score' => 25,
            'after_n_days' => 10,
        ],
        [
            'id' => 4,
            'name' => 'steadfast',
            'description' => 'The user earns this after fifteen days of endurance in the challenge',
            'score' => 50,
            'after_n_days' => 15,
        ],
        [
            'id' => 5,
            'name' => 'strong',
            'description' => 'The user earns this after twenty days of endurance in the challenge',
            'score' => 100,
            'after_n_days' => 20,
        ],
        [
            'id' => 6,
            'name' => 'warrior',
            'description' => 'The user earns this after twenty-five days of endurance in the challenge',
            'score' => 200,
            'after_n_days' => 25,
        ],
        [
            'id' => 7,
            'name' => 'hero',
            'description' => 'The user earns this after thirty days of endurance in the challenge',
            'score' => 300,
            'after_n_days' => 30,
        ],
    ],
];
