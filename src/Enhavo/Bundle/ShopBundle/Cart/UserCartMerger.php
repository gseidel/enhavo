<?php
/**
 * UserCartMerger.php
 *
 * @since 25/09/16
 * @author gseidel
 */

namespace Enhavo\Bundle\ShopBundle\Cart;

use Enhavo\Bundle\UserBundle\Model\UserInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Order\Context\CartContextInterface;

/**
 * Class UserCartMerger
 *
 * If user has a current cart with items, after login the current cart will be used and saved to user
 * If user has a current cart no items, after login a saved cart will be used now as current cart
 *
 * @package Enhavo\Bundle\ShopBundle\Cart
 */
class UserCartMerger
{
    /**
     * @var CartContextInterface
     */
    private $storedCartContext;

    /**
     * @var CartContextInterface
     */
    private $currentCartContext;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(
        CartContextInterface $storedCartContext,
        CartContextInterface $currentCartContext,
        EntityManagerInterface $em)
    {
        $this->currentCartContext = $currentCartContext;
        $this->storedCartContext = $storedCartContext;
        $this->em = $em;
    }

    /**
     *
     * @param UserInterface $user
     */
    public function merge(UserInterface $user)
    {
        $currentCart = $this->currentCartContext->getCart();
        $storedCart = $this->storedCartContext->getCart();

        if($storedCart !== $currentCart) {
            foreach($storedCart->getItems() as $item) {
                $currentCart->addItem($item);
            }
        }

        $this->em->flush();
    }
}