<?php

namespace Enhavo\Bundle\CalendarBundle\DependencyInjection;

use Enhavo\Bundle\AppBundle\Factory\Factory;
use Enhavo\Bundle\CalendarBundle\Controller\AppointmentController;
use Enhavo\Bundle\CalendarBundle\Entity\Appointment;
use Enhavo\Bundle\CalendarBundle\Form\Type\AppointmentType;
use Enhavo\Bundle\CalendarBundle\Repository\AppointmentRepository;
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
        $rootNode = $treeBuilder->root('enhavo_calendar');

        $rootNode
            // Driver used by the resource bundle
            ->children()
                ->scalarNode('driver')->defaultValue('doctrine/orm')->end()
            ->end()

            ->children()
                ->arrayNode('resources')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('appointment')
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
                                        ->scalarNode('model')->defaultValue(Appointment::class)->cannotBeEmpty()->end()
                                        ->scalarNode('controller')->defaultValue(AppointmentController::class)->cannotBeEmpty()->end()
                                        ->scalarNode('repository')->defaultValue(AppointmentRepository::class)->cannotBeEmpty()->end()
                                        ->scalarNode('factory')->defaultValue(Factory::class)->cannotBeEmpty()->end()
                                        ->scalarNode('form')->defaultValue(AppointmentType::class)->cannotBeEmpty()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->variableNode('importer')
                ->end()
                ->arrayNode('exporter')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('calendarName')->defaultValue('enhavo')->end()
                    ->end()
                ->end()
            ->end()

        ;

        return $treeBuilder;
    }
}
