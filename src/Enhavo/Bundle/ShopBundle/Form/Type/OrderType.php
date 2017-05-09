<?php
/**
 * OrderType.php
 *
 * @since 14/08/16
 * @author gseidel
 */

namespace Enhavo\Bundle\ShopBundle\Form\Type;

use Enhavo\Bundle\AppBundle\Form\Type\BooleanType;
use Enhavo\Bundle\ShopBundle\Model\OrderInterface;
use Sylius\Component\Payment\Model\PaymentInterface;
use Enhavo\Bundle\ShopBundle\Model\ShipmentInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('state', ChoiceType::class, [
            'multiple' => false,
            'expanded' => true,
            'choices' => [
                 'order.form.label.state.confirmed' => OrderInterface::STATE_CONFIRMED,
                 'order.form.label.state.cancelled' => OrderInterface::STATE_CANCELLED ,
                 'order.form.label.state.returned' => OrderInterface::STATE_RETURNED,
            ],
            'translation_domain' => 'EnhavoShopBundle',
            'label' => 'order.form.label.state.label'
        ]);

        $builder->add('paymentState', ChoiceType::class, [
            'multiple' => false,
            'expanded' => true,
            'choices' => [
                'order.form.label.payment.pending' => PaymentInterface::STATE_PENDING,
                 'order.form.label.payment.completed' => PaymentInterface::STATE_COMPLETED,
            ],
            'translation_domain' => 'EnhavoShopBundle',
            'label' => 'order.form.label.payment.label'
        ]);

        $builder->add('shippingState', ChoiceType::class, [
            'multiple' => false,
            'expanded' => true,
            'choices' => [
                 'order.form.label.shipping.pending' => ShipmentInterface::STATE_PENDING,
                 'order.form.label.shipping.ready' => ShipmentInterface::STATE_READY,
                 'order.form.label.shipping.shipped' => ShipmentInterface::STATE_SHIPPED
            ],
            'translation_domain' => 'EnhavoShopBundle',
            'label' => 'order.form.label.shipping.label'
        ]);

        $builder->add('billingAddress', 'sylius_address');
        $builder->add('shippingAddress', 'sylius_address');
        $builder->add('differentBillingAddress', BooleanType::class);

        $builder->add('payment', PaymentType::class);
    }

    public function getName()
    {
        return 'enhavo_shop_order';
    }
}