<?php
namespace Enhavo\Bundle\AppBundle\Controller;

use Enhavo\Bundle\AppBundle\Exception\BadMethodCallException;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration as SyliusRequestConfiguration;

class DuplicateResourceFactory implements DuplicateResourceFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(SyliusRequestConfiguration $requestConfiguration, FactoryInterface $factory)
    {
        if (null === $method = $requestConfiguration->getFactoryMethod()) {
            return $factory->createNew();
        }

        $arguments = array_values($requestConfiguration->getFactoryArguments());

        return $factory->$method(...$arguments);
    }

    /**
     * {@inheritdoc}
     */
    public function duplicate(RequestConfiguration $requestConfiguration, FactoryInterface $factory, ResourceInterface $originalResource)
    {
        if (null === $method = $requestConfiguration->getFactoryMethod()) {
            $method = 'duplicate';
        }

        if (!method_exists($factory, $method)) {
            throw new BadMethodCallException('Method "' . $method . '" not found in factory class');
        }

        $callable = [$factory, $method];
        $arguments = array_merge([$originalResource], $requestConfiguration->getFactoryArguments());

        return call_user_func_array($callable, $arguments);
    }
}
