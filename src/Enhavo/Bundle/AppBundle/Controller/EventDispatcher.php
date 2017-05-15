<?php
/**
 * EventDispatcher.php
 *
 * @since 26/06/16
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\Controller;

use Enhavo\Bundle\AppBundle\Event\PreviewEvent;
use Sylius\Bundle\ResourceBundle\Controller\EventDispatcherInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcherInterface;

class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var SymfonyEventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @param SymfonyEventDispatcherInterface $eventDispatcher
     */
    public function __construct(SymfonyEventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatch($eventName, RequestConfiguration $requestConfiguration, ResourceInterface $resource)
    {
        $eventName = $requestConfiguration->getEvent() ?: $eventName;
        $metadata = $requestConfiguration->getMetadata();
        $event = $this->getEvent($resource);

        $this->eventDispatcher->dispatch(sprintf('%s.%s.%s', $metadata->getApplicationName(), $metadata->getName(), $eventName), $event);

        return $event;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchPreEvent($eventName, RequestConfiguration $requestConfiguration, ResourceInterface $resource)
    {
        $eventName = $requestConfiguration->getEvent() ?: $eventName;
        $this->eventDispatcher->dispatch(sprintf('enhavo_app.pre_%s', $eventName), new ResourceControllerEvent($resource));

        $eventName = $requestConfiguration->getEvent() ?: $eventName;
        $metadata = $requestConfiguration->getMetadata();
        $event = $this->getEvent($resource);

        $this->eventDispatcher->dispatch(sprintf('%s.%s.pre_%s', $metadata->getApplicationName(), $metadata->getName(), $eventName), $event);

        return $event;
    }

    /**
     * {@inheritdoc}
     */
    public function dispatchPostEvent($eventName, RequestConfiguration $requestConfiguration, ResourceInterface $resource)
    {
        $eventName = $requestConfiguration->getEvent() ?: $eventName;
        $this->eventDispatcher->dispatch(sprintf('enhavo_app.post_%s', $eventName), new ResourceControllerEvent($resource));

        $eventName = $requestConfiguration->getEvent() ?: $eventName;
        $metadata = $requestConfiguration->getMetadata();
        $event = $this->getEvent($resource);

        $this->eventDispatcher->dispatch(sprintf('%s.%s.post_%s', $metadata->getApplicationName(), $metadata->getName(), $eventName), $event);

        return $event;
    }

    /**
     * @param ResourceInterface $resource
     *
     * @return ResourceControllerEvent
     */
    private function getEvent(ResourceInterface $resource)
    {
        return new ResourceControllerEvent($resource);
    }

    public function dispatchInitEvent($eventName, RequestConfiguration $requestConfiguration)
    {
        $this->eventDispatcher->dispatch($eventName, new PreviewEvent($requestConfiguration->getRequest(), $requestConfiguration));
    }
}