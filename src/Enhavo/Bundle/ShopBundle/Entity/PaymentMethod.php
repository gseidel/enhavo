<?php
/**
 * PaymentMethod.php
 *
 * @since 23/06/17
 * @author gseidel
 */

namespace Enhavo\Bundle\ShopBundle\Entity;


use Payum\Core\Model\GatewayConfigInterface;
use Sylius\Component\Payment\Model\PaymentMethod as SyliusPaymentMethod;

class PaymentMethod extends SyliusPaymentMethod
{
    /**
     * @var GatewayConfigInterface
     */
    protected $gatewayConfig;

    /**
     * @return GatewayConfigInterface
     */
    public function getGatewayConfig()
    {
        return $this->gatewayConfig;
    }

    /**
     * @param GatewayConfigInterface $gatewayConfig
     */
    public function setGatewayConfig($gatewayConfig)
    {
        $this->gatewayConfig = $gatewayConfig;
    }
}