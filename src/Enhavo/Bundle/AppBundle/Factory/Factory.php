<?php
/**
 * Factory.php
 *
 * @since 07/05/17
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\Factory;

use Sylius\Component\Resource\Factory\FactoryInterface;

class Factory implements FactoryInterface
{
    /**
     * @var string
     */
    private $className;

    /**
     * @param string $className
     */
    public function __construct($className)
    {
        $this->className = $className;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        return new $this->className();
    }
}