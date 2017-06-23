<?php

namespace Enhavo\Behat\Context;

use Enhavo\Bundle\ShopBundle\Entity\Product;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class ShopContext extends KernelContext
{
    /**
     * @Given following products
     */
    public function followingProducts(TableNode $table)
    {
        foreach ($table->getHash() as $data) {
            $this->findOrCreateProduct($data['code'], $data['title'], $data['price']);
        }
        $this->getManager()->flush();
    }

    /**
     * @Given I add :amount product with code :code to cart
     */
    public function iAddProductWithCodeToCart($amount, $code)
    {
        
    }

    /**
     * @Then I see :amount product with code :code in my cart
     */
    public function iSeeProductWithCodeInMyCart($arg1, $arg2)
    {

    }

    protected function findOrCreateProduct($code, $title, $price)
    {
        $product = $this->get('sylius.repository.product')->findOneBy([
            'code' => $code
        ]);

        if($product === null) {
            $product = new Product();
            $product->setCode($code);
            $this->getManager()->persist($product);
        }

        $product->setPrice($price);
        $product->setTitle($title);

        return $product;
    }
}