<?php
/**
 * Created by PhpStorm.
 * User: philippsester
 * Date: 28.08.20
 * Time: 17:37
 */

namespace Enhavo\Bundle\ShopBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\TaxationBundle\Form\Type\TaxCategoryType as SyliusTaxCategoryType;

class TaxCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
    }

    public function getParent()
    {
        return SyliusTaxCategoryType::class;
    }
}
