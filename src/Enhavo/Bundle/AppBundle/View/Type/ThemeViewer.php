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

class ThemeViewer extends BaseViewer
{
    public function getType()
    {
        return 'app';
    }

    protected function buildTemplateParameters(ParameterBag $parameters, ViewConfiguration $viewConfiguration, array $options)
    {
        parent::buildTemplateParameters($parameters, $viewConfiguration, $options);
    }

    public function configureOptions(OptionsResolver $optionsResolver)
    {
        parent::configureOptions($optionsResolver);

        $optionsResolver->setDefaults([
            'template' => 'EnhavoAppBundle:Viewer:app.html.twig'
        ]);
    }
}