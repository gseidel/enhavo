<?php
/**
 * StoredCartContext.php
 *
 * @since 12/05/17
 * @author gseidel
 */

namespace Enhavo\Bundle\ShopBundle\Cart;

use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class StoredCartContext implements CartContextInterface
{
    /**
     * @var RepositoryInterface
     */
    private $orderRepository;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(RepositoryInterface $orderRepository, TokenStorageInterface $tokenStorage)
    {
        $this->orderRepository = $orderRepository;
        $this->tokenStorage = $tokenStorage;
    }

    public function getCart()
    {
        $carts = $this->orderRepository->findBy([
            'user' => $this->tokenStorage->getToken()->getUser()
        ], [
            'createdAt' => 'DESC'
        ], 1);

        if(count($carts)) {
            return [0];
        }
        return null;
    }
}