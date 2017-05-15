<?php

namespace Enhavo\Bundle\PageBundle\Form\Type;

use Enhavo\Bundle\GridBundle\Form\Type\GridType;
use Enhavo\Bundle\ContentBundle\Form\Type\ContentType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    /**
     * @var string
     */
    protected $dataClass;

    /**
     * @var string
     */
    protected $route;

    /**
     * @var bool
     */
    protected $routingStrategy;

    public function __construct($dataClass, $routingStrategy, $route)
    {
        $this->dataClass = $dataClass;
        $this->route = $route;
        $this->routingStrategy = $routingStrategy;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('grid', GridType::class, array(
            'label' => 'form.label.content',
            'translation_domain' => 'EnhavoAppBundle',
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults( array(
            'data_class' => $this->dataClass,
            'routing_strategy' => $this->routingStrategy,
            'routing_route' => $this->route
        ));
    }

    public function getParent()
    {
        return ContentType::class;
    }

    public function getName()
    {
        return 'enhavo_page_page';
    }
}