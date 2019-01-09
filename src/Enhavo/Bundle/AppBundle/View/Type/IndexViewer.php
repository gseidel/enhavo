<?php
/**
 * IndexViewer.php
 *
 * @since 26/06/15
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\View\Type;

use Enhavo\Bundle\AppBundle\View\ViewConfiguration;
use Sylius\Component\Resource\Metadata\MetadataInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IndexViewer extends ResourceViewer
{
    public function getType()
    {
        return 'index';
    }

    protected function buildTemplateParameters(ParameterBag $parameters, ViewConfiguration $viewConfiguration, array $options)
    {
        parent::buildTemplateParameters($parameters, $viewConfiguration, $options);

        $parameters->set('blocks', $viewConfiguration->getArray('stylesheets', [
            $this->createBlock($options),
            $options['blocks']
        ]));

        $parameters->set('actions', $viewConfiguration->getArray('actions', [
            $this->createActions($options),
            $options['actions']
        ]));

        $parameters->set('title', $viewConfiguration->get('title', [
            $options['title']
        ]));
    }

    private function createBlock($options)
    {
        /** @var MetadataInterface $metadata */
        $metadata = $options['metadata'];

        $default = [
            'table' => [
                'type' => 'table',
                'table_route' => sprintf('%s_%s_table', $metadata->getApplicationName(), $this->getUnderscoreName($metadata)),
                'update_route' => sprintf('%s_%s_update', $metadata->getApplicationName(), $this->getUnderscoreName($metadata)),
            ]
        ];

        return $default;
    }

    private function createActions($options)
    {
        /** @var MetadataInterface $metadata */
        $metadata = $options['metadata'];

        $default = [
            'create' => [
                'type' => 'create',
                'route' => sprintf('%s_%s_create', $metadata->getApplicationName(), $this->getUnderscoreName($metadata)),
            ]
        ];

        return $default;
    }

    public function configureOptions(OptionsResolver $optionsResolver)
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->setDefaults([
            'title' => '',
            'blocks' => [],
            'actions' => [],
            'apps' => ['app/Index'],
            'template' => 'EnhavoAppBundle:Viewer:app.html.twig'
        ]);
    }
}