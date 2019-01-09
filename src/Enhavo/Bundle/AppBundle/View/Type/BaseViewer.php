<?php
/**
 * AppViewer.php
 *
 * @since 29/05/15
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\View\Type;

use Enhavo\Bundle\AppBundle\View\AbstractViewType;
use Enhavo\Bundle\AppBundle\View\ViewConfiguration;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseViewer extends AbstractViewType
{
    public function getType()
    {
        return 'base';
    }

    protected function buildTemplateParameters(ParameterBag $parameters, ViewConfiguration $viewConfiguration, array $options)
    {
        parent::buildTemplateParameters($parameters, $viewConfiguration, $options);

        $parameters->set('stylesheets', $viewConfiguration->getArray('stylesheets', [
            $this->container->getParameter('enhavo_app.stylesheets'),
            $options['stylesheets']
        ]));

        $parameters->set('javascripts', $viewConfiguration->getArray('javascripts', [
            $this->container->getParameter('enhavo_app.javascripts'),
            $options['javascripts']
        ]));

        $parameters->set('requireJsApps', $viewConfiguration->getArray('apps', [
            $this->container->getParameter('enhavo_app.apps'),
            $options['apps']
        ]));

        $parameters->set('translationDomain', $viewConfiguration->get('translationDomain', [
            $options['translation_domain']
        ]));

        foreach($options['parameters'] as $key => $value) {
            $parameters->set($key, $value);
        }
    }

    public function configureOptions(OptionsResolver $optionsResolver)
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->setDefaults([
            'javascripts' => [],
            'stylesheets' => [],
            'apps' => [],
            'translation_domain' => null,
            'template' => 'EnhavoAppBundle:Viewer:base.html.twig',
            'parameters' => []
        ]);
    }
}