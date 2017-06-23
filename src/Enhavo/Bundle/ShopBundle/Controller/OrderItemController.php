<?php
/**
 * CartItemController.php
 *
 * @since 27/08/16
 * @author gseidel
 */

namespace Enhavo\Bundle\ShopBundle\Controller;

use Sylius\Bundle\OrderBundle\Controller\OrderItemController as SyliusCartItemController;

class OrderItemController extends SyliusCartItemController
{
    use CartSummaryTrait;
}