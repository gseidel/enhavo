<?php

namespace Enhavo\Bundle\ShopBundle\Form\Type;

use Sylius\Bundle\OrderBundle\Form\Type\CartItemType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Enhavo\Bundle\ShopBundle\Model\ProductInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AddToCartType
 *
 * This class is a port from SyliusCoreBundle.
 *
 * @package Enhavo\Bundle\ShopBundle\Form\Type
 */
class AddToCartType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cartItem', CartItemType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefined([
                'product',
            ])
            ->setAllowedTypes('product', ProductInterface::class)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return $this->getName();
    }

    public function getName()
    {
        return 'enhavo_add_to_cart';
    }
}
