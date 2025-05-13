<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Mydnic\Volet\Features\FeatureManager;
use Mydnic\Volet\Features\FeedbackMessages;
use Mydnic\VoletFeatureBoard\VoletFeatureBoard;

class VoletServiceProvider extends ServiceProvider
{
    public function boot(FeatureManager $volet): void
    {
        // Register and configure the Feedback Messages feature
        $this->registerFeedbackMessagesFeature($volet);

        // Example of registering a custom feature
        $volet->register(
            (new VoletFeatureBoard())
                ->setLabel('Fonctionnalités')
                ->addCategory(
                    slug: 'idea',
                    name: 'Idée',
                    icon: 'https://api.iconify.design/lucide:lightbulb.svg?color=%23888888'
                )
                ->addCategory(
                    slug: 'issue',
                    name: 'Bug',
                    icon: 'https://api.iconify.design/lucide:wrench.svg?color=%23888888'
                )
        );
    }

    private function registerFeedbackMessagesFeature(FeatureManager $volet): void
    {
        $volet->register(
            (new FeedbackMessages)
                // Configure feature display
                ->setLabel('Envoyez-nous vos commentaires')
                ->setIcon('https://api.iconify.design/lucide:message-square.svg?color=%23888888')

                // Add feedback categories
                ->addCategory(
                    slug: 'bug',
                    name: 'Signaler un bug',
                    icon: 'https://api.iconify.design/lucide:bug.svg?color=%23888888'
                )
                ->addCategory(
                    slug: 'improvement',
                    name: 'Amélioration',
                    icon: 'https://api.iconify.design/lucide:lightbulb.svg?color=%23888888'
                )
                ->addCategory(
                    slug: 'general',
                    name: 'Général',
                    icon: 'https://api.iconify.design/lucide:smile.svg?color=%23888888'
                )
        );
    }
}
