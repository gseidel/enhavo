<?php
/**
 * AbstractViewer.php
 *
 * @since 29/05/15
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\View;

use Enhavo\Bundle\AppBundle\Type\AbstractType;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class AbstractViewType extends AbstractType implements ViewTypeInterface
{
    /**
     * {@inheritdoc}
     */
    public function createView(ViewConfiguration $configuration, array $options = []): View
    {
        $view = $this->create($options);
        // set template data
        $parameters = new ParameterBag();
        $parameters->set('data', $options['data']);
        $this->buildTemplateParameters($parameters, $configuration, $options);
        $templateVars = [];
        foreach($parameters as $key => $value) {
            $templateVars[$key] = $value;
        }
        $view->setTemplateData($templateVars);
        $view->setTemplate($configuration->get('template', [$options['template']]));
        return $view;
    }

    protected function create($options): View
    {
        $view = null;
        if(isset($options['data'])) {
            $view = View::create($options['data'], 200);
        } else {
            $view = View::create(null, 200);
        }
        return $view;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults([
            'template' => null,
            'data' => null
        ]);
    }

    protected function buildTemplateParameters(ParameterBag $parameters, ViewConfiguration $configuration, array $options)
    {

    }
}