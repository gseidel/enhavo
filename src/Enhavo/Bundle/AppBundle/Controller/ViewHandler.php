<?php
/**
 * ViewHandler.php
 *
 * @since 13/10/16
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\Controller;

use FOS\RestBundle\View\View;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfiguration;
use Sylius\Bundle\ResourceBundle\Controller\ViewHandlerInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;
use FOS\RestBundle\View\ViewHandler as RestViewHandler;

class ViewHandler implements ViewHandlerInterface
{
    /**
     * @var RestViewHandler
     */
    private $restViewHandler;

    /**
     * @param RestViewHandler $restViewHandler
     */
    public function __construct(RestViewHandler $restViewHandler)
    {
        $this->restViewHandler = $restViewHandler;
    }

    /**
     * {@inheritdoc}
     */
    public function handle(RequestConfiguration $requestConfiguration, View $view)
    {
        $response = $view->getResponse();
        if($response->getContent() || $response instanceof StreamedResponse) {
            return $view->getResponse();
        }

        if (!$requestConfiguration->isHtmlRequest()) {
            $this->restViewHandler->setExclusionStrategyGroups($requestConfiguration->getSerializationGroups());

            if ($version = $requestConfiguration->getSerializationVersion()) {
                $this->restViewHandler->setExclusionStrategyVersion($version);
            }

            $view->getSerializationContext()->enableMaxDepthChecks();
        }

        return $this->restViewHandler->handle($view);
    }
}