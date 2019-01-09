<?php
/**
 * AppViewer.php
 *
 * @since 29/05/15
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\View\Type;

use Enhavo\Bundle\AppBundle\View\ViewConfiguration;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppViewer extends BaseViewer
{
    public function getType()
    {
        return 'app';
    }

    protected function buildTemplateParameters(ParameterBag $parameters, ViewConfiguration $viewConfiguration, array $options)
    {
        parent::buildTemplateParameters($parameters, $viewConfiguration, $options);

        $parameters->set('blocks', $viewConfiguration->getArray('blocks', [
            $options['blocks']
        ]));

        $parameters->set('actions', $viewConfiguration->getArray('actions', [
            $options['actions']
        ]));

        $parameters->set('title', $viewConfiguration->get('title', [
            $options['title']
        ]));
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