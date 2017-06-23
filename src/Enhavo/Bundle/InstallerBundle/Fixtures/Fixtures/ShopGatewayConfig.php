<?php
/**
 * ShopGatewayConfig.php
 *
 * @since 23/06/17
 * @author gseidel
 */

namespace Enhavo\Bundle\InstallerBundle\Fixtures\Fixtures;

use Enhavo\Bundle\InstallerBundle\Fixtures\AbstractFixture;
use Sylius\Bundle\PayumBundle\Model\GatewayConfig;

class ShopGatewayConfig extends AbstractFixture
{
    /**
     * @inheritdoc
     */
    function create($args)
    {
        $country = new GatewayConfig();
        $country->setGatewayName($args['gatewayName']);
        $country->setFactoryName($args['factoryName']);
        return $country;
    }

    /**
     * @inheritdoc
     */
    function getName()
    {
        return 'ShopGatewayConfig';
    }

    /**
     * @inheritdoc
     */
    function getOrder()
    {
        return 20;
    }
}