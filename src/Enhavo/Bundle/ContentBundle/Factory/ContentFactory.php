<?php
namespace Enhavo\Bundle\ContentBundle\Factory;

use Enhavo\Bundle\AppBundle\Factory\Factory;
use Enhavo\Bundle\ContentBundle\Entity\Content;

class ContentFactory extends Factory
{
    /**
     * @param Content|null $originalResource
     * @return Content
     */
    public function duplicate($originalResource)
    {
        if (!$originalResource) {
            return null;
        }

        /** @var Content $newResource */
        $newResource = $this->createNew();

        $newResource->setTitle($originalResource->getTitle());
        $newResource->setSlug($originalResource->getSlug());
        $newResource->setMetaDescription($originalResource->getMetaDescription());
        $newResource->setPageTitle($originalResource->getPageTitle());
        $newResource->setPriority($originalResource->getPriority());
        $newResource->setChangeFrequency($originalResource->getChangeFrequency());
        $newResource->setPublic($originalResource->isPublic());
        $newResource->setPublicationDate($originalResource->getPublicationDate());
        $newResource->setPublishedUntil($originalResource->getPublishedUntil());
        $newResource->setCreated(new \DateTime());
        $newResource->setUpdated(new \DateTime());

        return $newResource;
    }

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
