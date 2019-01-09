<?php
/**
 * CreateViewer.php
 *
 * @since 29/05/15
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\View\Type;

use Enhavo\Bundle\AppBundle\View\AbstractViewType;
use Enhavo\Bundle\AppBundle\View\ViewConfiguration;
use FOS\RestBundle\View\View;
use Sylius\Component\Resource\Metadata\MetadataInterface;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateViewer extends AbstractViewType
{
    /**
     * @var string[]
     */
    private $formThemes;

    /**
     * CreateViewer constructor.
     * @param array $formThemes
     */
    public function __construct(array $formThemes)
    {
        $this->formThemes = $formThemes;
    }

    public function getType()
    {
        return 'create';
    }

    /**
     * {@inheritdoc}
     */
    public function create($options): View
    {
        /** @var FormInterface $form */
        $form = $options['form'];

        if($form->isSubmitted()) {
            $view = View::create($form, $form->isValid() ? 200 : 400);
            $view->setFormat('json');
            return $view;
        }

        return parent::create($options);
    }

    protected function buildTemplateParameters(ParameterBag $parameters, ViewConfiguration $viewConfiguration, array $options)
    {
        parent::buildTemplateParameters($parameters, $viewConfiguration, $options);

        /** @var MetadataInterface $metadata */
        $metadata = $options['metadata'];
        /** @var Form $form */
        $form = $options['form'];

        $parameters->set('form', $form->createView());

        $parameters->set('tabs', $this->mergeConfigArray([
            [
                'main' => [
                    'label' => sprintf('%s.label.%s', $this->getUnderscoreName($metadata), $this->getUnderscoreName($metadata)),
                    'template' => 'EnhavoAppBundle:Tab:default.html.twig'
                ],
            ],
            $options['tabs'],
            $this->getViewerOption('tabs', $viewConfiguration)
        ]));

        $parameters->set('form_template', $this->mergeConfig([
            $options['form_template'],
            $this->getViewerOption('form.template', $viewConfiguration)
        ]));

        $parameters->set('form_action', $this->mergeConfig([
            sprintf('%s_%s_create', $metadata->getApplicationName(), $this->getUnderscoreName($metadata)),
            $options['form_action'],
            $this->getViewerOption('form.action', $viewConfiguration)
        ]));

        $parameters->set('form_action_parameters', $this->mergeConfigArray([
            $options['form_action_parameters'],
            $this->getViewerOption('form.action_parameters', $viewConfiguration)
        ]));

        $parameters->set('form_themes', $this->mergeConfigArray([
            $this->formThemes,
            $options['form_themes'],
            $this->getViewerOption('form.themes', $viewConfiguration)
        ]));

        $parameters->set('buttons', $this->mergeConfigArray([
            'buttons' => [
                'cancel' => [
                    'type' => 'cancel',
                ],
                'save' => [
                    'type' => 'save',
                ]
            ],
            $options['buttons'],
            $this->getViewerOption('buttons', $viewConfiguration)
        ]));

        $parameters->set('data', $options['resource']);
    }

    public function configureOptions(OptionsResolver $optionsResolver)
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->setDefaults([
            'tabs' => [],
            'buttons' => [],
            'form' => null,
            'form_themes' => [],
            'form_action' => null,
            'form_action_parameters' => [],
            'form_template' => 'EnhavoAppBundle:View:tab.html.twig',
            'template' => 'EnhavoAppBundle:Resource:create.html.twig'
        ]);
    }
}