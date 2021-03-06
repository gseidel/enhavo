<?php
/**
 * Created by PhpStorm.
 * User: gseidel
 * Date: 2020-06-08
 * Time: 10:56
 */

namespace Enhavo\Component\Type;

use Symfony\Component\OptionsResolver\OptionsResolver;

class AbstractType implements TypeInterface
{
    /** @var self|null */
    protected $parent;

    /** @var string|null */
    protected $key;

    public function setParent(TypeInterface $parent)
    {
        $this->parent = $parent;
    }

    public static function getParentType(): ?string
    {
        return null;
    }

    public static function getName(): ?string
    {
        return null;
    }

    /**
     * @param string|null $key
     */
    public function setKey(?string $key): void
    {
        $this->key = $key;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }
}
