<?php
/**
 * Created by PhpStorm.
 * User: gseidel
 * Date: 03.01.19
 * Time: 13:21
 */

namespace Enhavo\Bundle\AppBundle\View\Type;

use Enhavo\Bundle\AppBundle\View\AbstractViewType;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Component\Resource\Metadata\MetadataInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResourceViewer extends BaseViewer
{
    public function configureOptions(OptionsResolver $optionsResolver)
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->setRequired([
            'metadata', 'request_configuration'
        ]);
    }

    /**
     * @param $options
     * @return RequestConfiguration
     */
    protected function getRequestConfiguration($options)
    {
        return $options['request_configuration'];
    }

    /**
     * @param $options
     * @return MetadataInterface
     */
    protected function getMetadata($options)
    {
        return $options['metadata'];
    }

    /**
     * @return ResourceInterface
     */
    protected function getResource($options)
    {
        return $options['data'];
    }

    protected function getUnderscoreName(MetadataInterface $metadata)
    {
        $name = $metadata->getHumanizedName();
        $name = str_replace(' ', '_', $name);
        return $name;
    }
}