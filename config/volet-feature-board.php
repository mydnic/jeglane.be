<?php

use Mydnic\VoletFeatureBoard\Http\Controllers\CommentController;
use Mydnic\VoletFeatureBoard\Http\Controllers\FeatureController;
use Mydnic\VoletFeatureBoard\Http\Controllers\VoteController;
use Mydnic\VoletFeatureBoard\Models\Comment;
use Mydnic\VoletFeatureBoard\Models\Feature;
use Mydnic\VoletFeatureBoard\Models\Vote;

return [
    'tables' => [
        'features' => 'volet_features',
        'votes' => 'volet_feature_user_votes',
        'comments' => 'volet_feature_comments',
    ],

    // The controller class to use for feedback endpoints
    'controllers' => [
        'features' => FeatureController::class,
        'votes' => VoteController::class,
        'comments' => CommentController::class,
    ],

    // The model class to use for feedback messages
    'models' => [
        'feature' => Feature::class,
        'vote' => Vote::class,
        'comment' => Comment::class,
    ],

    'routes' => [
        // The URI prefix for feedback message routes
        'prefix' => 'feature-board',

        // The middleware to apply to feedback message routes
        'middleware' => [
            'api',
            // Add your custom middleware here
            // 'auth',
            // 'verified',
        ],
    ],

    'content' => [
        'success-icon' => 'https://api.iconify.design/heroicons:check-circle.svg?color=%2322c55e',
    ],
];
