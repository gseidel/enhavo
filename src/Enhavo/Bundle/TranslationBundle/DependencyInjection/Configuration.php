<?php

namespace Enhavo\Bundle\TranslationBundle\DependencyInjection;

use Enhavo\Bundle\AppBundle\Controller\ResourceController;
use Enhavo\Bundle\AppBundle\Factory\Factory;
use Enhavo\Bundle\TranslationBundle\Entity\TranslationString;
use Enhavo\Bundle\TranslationBundle\Form\Type\TranslationStringType;
use Enhavo\Bundle\TranslationBundle\Repository\TranslationStringRepository;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('enhavo_translation');

        $rootNode
            ->children()
               ->scalarNode('driver')->defaultValue('doctrine/orm')->end()
            ->end()
            ->children()
                ->scalarNode('translate')->defaultValue(false)->end()
            ->end()
            ->children()
                ->scalarNode('default_locale')->end()
            ->end()
            ->children()
                ->arrayNode('locales')
                    ->useAttributeAsKey('name')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('label')->end()
                            ->scalarNode('flag')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->children()
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('translation_string')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('options')->end()
                                ->arrayNode('routing')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('strategy')->defaultValue('slug')->end()
                                        ->scalarNode('route')->defaultValue(null)->end()
                                    ->end()
                                ->end()
                                ->arrayNode('classes')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('model')->defaultValue(TranslationString::class)->end()
                                        ->scalarNode('controller')->defaultValue(ResourceController::class)->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->end()
                                        ->scalarNode('repository')->defaultValue(TranslationStringRepository::class)->end()
                                        ->scalarNode('form')->defaultValue(TranslationStringType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->children()
                ->arrayNode('translation_strings')
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
