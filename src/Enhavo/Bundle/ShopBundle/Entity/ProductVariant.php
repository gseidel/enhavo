<?php
/**
 * ProductVariant.php
 *
 * @since 25/10/16
 * @author gseidel
 */

namespace Enhavo\Bundle\ShopBundle\Entity;

use Enhavo\Bundle\MediaBundle\Model\FileInterface;
use Enhavo\Bundle\ShopBundle\Model\ProductInterface;
use Sylius\Component\Taxation\Model\TaxRateInterface;
use Sylius\Component\Product\Model\ProductVariant as SyliusProductVariant;

class ProductVariant extends SyliusProductVariant
{
    /**
     * @var FileInterface
     */
    private $picture;

    /**
     * @var TaxRateInterface
     */
    private $taxRate;

    /**
     * @var int
     */
    private $variantPrice;

    /**
     * @var int
     */
    private $variantHeight;

    /**
     * @var int
     */
    private $variantWidth;

    /**
     * @var int
     */
    private $variantDepth;

    /**
     * @var int
     */
    private $variantVolume;

    /**
     * @var int
     */
    private $variantWeight;

    /**
     * @return int
     */
    public function getVariantPrice()
    {
        return $this->variantPrice;
    }

    /**
     * @param int $variantPrice
     */
    public function setVariantPrice($variantPrice)
    {
        $this->variantPrice = $variantPrice;
    }

    /**
     * @return int
     */
    public function getVariantHeight()
    {
        return $this->variantHeight;
    }

    /**
     * @param int $variantHeight
     */
    public function setVariantHeight($variantHeight)
    {
        $this->variantHeight = $variantHeight;
    }

    /**
     * @return int
     */
    public function getVariantWidth()
    {
        return $this->variantWidth;
    }

    /**
     * @param int $variantWidth
     */
    public function setVariantWidth($variantWidth)
    {
        $this->variantWidth = $variantWidth;
    }

    /**
     * @return int
     */
    public function getVariantDepth()
    {
        return $this->variantDepth;
    }

    /**
     * @param int $variantDepth
     */
    public function setVariantDepth($variantDepth)
    {
        $this->variantDepth = $variantDepth;
    }

    /**
     * @return int
     */
    public function getVariantVolume()
    {
        return $this->variantVolume;
    }

    /**
     * @param int $variantVolume
     */
    public function setVariantVolume($variantVolume)
    {
        $this->variantVolume = $variantVolume;
    }

    /**
     * @return int
     */
    public function getVariantWeight()
    {
        return $this->variantWeight;
    }

    /**
     * @param int $variantWeight
     */
    public function setVariantWeight($variantWeight)
    {
        $this->variantWeight = $variantWeight;
    }

    public function getWidth()
    {
        $product = $this->getObject();
        if($product instanceof ProductInterface && $this->getVariantWidth() === null) {
            return $product->getWidth();
        }
        return $this->getVariantWidth();
    }

    public function getHeight()
    {
        $product = $this->getObject();
        if($product instanceof ProductInterface && $this->getVariantHeight() === null) {
            return $product->getHeight();
        }
        return $this->getVariantHeight();
    }
    
    public function getDepth()
    {
        $product = $this->getObject();
        if($product instanceof ProductInterface && $this->getVariantDepth() === null) {
            return $product->getDepth();
        }
        return $this->getVariantDepth();
    }
    
    public function getPrice()
    {
        $product = $this->getObject();
        if($product instanceof ProductInterface && $this->getVariantPrice() === null) {
            return $product->getPrice();
        }
        return $this->getVariantPrice();
    }
    
    public function getVolume()
    {
        $product = $this->getObject();
        if($product instanceof ProductInterface && $this->getVariantVolume() === null) {
            return $product->getVolume();
        }
        return $this->getVariantVolume();
    }
    
    public function getWeight()
    {
        $product = $this->getObject();
        if($product instanceof ProductInterface && $this->getVariantWeight() === null) {
            return $product->getWeight();
        }
        return $this->getVariantWeight();
    }

    /**
     * @return FileInterface
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * @param FileInterface $picture
     */
    public function setPicture(FileInterface $picture = null)
    {
        $this->picture = $picture;
    }

    /**
     * @return TaxRateInterface
     */
    public function getTaxRate()
    {
        return $this->taxRate;
    }

    /**
     * @param TaxRateInterface $taxRate
     */
    public function setTaxRate(TaxRateInterface $taxRate = null)
    {
        $this->taxRate = $taxRate;
    }
}