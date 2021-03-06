<?php
/**
 * CartSummaryWidget.php
 *
 * @since 28/08/16
 * @author gseidel
 */

namespace Enhavo\Bundle\ShopBundle\Widget;

use Enhavo\Bundle\AppBundle\Type\AbstractType;
use Enhavo\Bundle\AppBundle\Widget\WidgetInterface;

class CartSummaryWidget extends AbstractType implements WidgetInterface
{
    public function getType()
    {
        return 'shop_cart_summary';
    }

    public function render($options)
    {
        $resolvedOptions = $this->resolveOptions([
            'template' => 'EnhavoShopBundle:Theme:Widget/cart-summary.html.twig',
            'cart' => null,
            'immutable' => false
        ], $options);

        $cart = $resolvedOptions['cart'];
        if(empty($cart)) {
            $cart = $this->container->get('sylius.cart_provider')->getCart();
        }
        
        return $this->renderTemplate($resolvedOptions['template'], [
            'cart' => $cart,
            'immutable' => $resolvedOptions['immutable']
        ]);
    }
}
