<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Points Configuration
    |--------------------------------------------------------------------------
    |
    | Points awarded when particular team wins or looses or draws the match.
    |
    */

    'points' => [
        'win' => 3,
        'draw' => 1,
        'loss' => 0,
    ],

    /*
    |--------------------------------------------------------------------------
    | Goals Configuration
    |--------------------------------------------------------------------------
    |
    | Minimum and Maximum goals team can score in single match
    |
    */

    'goals' => [
        'min' => 0,
        'max' => 5,
    ],

    /*
    |--------------------------------------------------------------------------
    | Show Predictions Configuration
    |--------------------------------------------------------------------------
    |
    | Show Predictions from which week? eg. min = 1, max = total count of weeks.
    |
    */

    'predictions' => [
        'showFrom' => 4,
    ]
];
