<?php

namespace Enhavo\Bundle\NewsletterBundle\DependencyInjection;

use Enhavo\Bundle\AppBundle\Factory\Factory;
use Enhavo\Bundle\NewsletterBundle\Controller\NewsletterController;
use Enhavo\Bundle\NewsletterBundle\Controller\SubscriberController;
use Enhavo\Bundle\NewsletterBundle\Entity\Newsletter;
use Enhavo\Bundle\NewsletterBundle\Entity\Subscriber;
use Enhavo\Bundle\NewsletterBundle\Form\Type\NewsletterType;
use Enhavo\Bundle\NewsletterBundle\Form\Type\SubscriberType;
use Enhavo\Bundle\NewsletterBundle\Repository\NewsletterRepository;
use Enhavo\Bundle\NewsletterBundle\Repository\SubscriberRepository;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('enhavo_newsletter');

        $rootNode
            ->children()
                // Driver used by the resource bundle
                ->scalarNode('driver')->defaultValue('doctrine/orm')->end()

                // Object manager used by the resource bundle, if not specified "default" will used
                ->scalarNode('object_manager')->defaultValue('default')->end()
            ->end()
            ->children()
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('newsletter')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Newsletter::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(NewsletterController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->defaultValue(NewsletterRepository::class)->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(NewsletterType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('subscriber')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(Subscriber::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(SubscriberController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->defaultValue(SubscriberRepository::class)->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(SubscriberType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        $rootNode
            ->children()
                ->arrayNode('groups')->addDefaultsIfNotSet()->end()
                ->arrayNode('storage')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default')->defaultValue('local')->end()
                        ->arrayNode('groups')
                        ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('defaults')->defaultValue([])->end()
                            ->end()
                        ->end()
                        ->variableNode('settings')->defaultValue([])->end()
                    ->end()
                ->end()

                ->arrayNode('strategy')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default')->defaultValue('notify')->end()
                        ->variableNode('settings')->defaultValue([])->end()
                    ->end()
                ->end()

                ->arrayNode('newsletter')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('mail')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('from')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->variableNode('forms')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
