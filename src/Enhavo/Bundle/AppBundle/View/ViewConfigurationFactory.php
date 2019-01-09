<?php
/**
 * Created by PhpStorm.
 * User: gseidel
 * Date: 03.01.19
 * Time: 13:45
 */

namespace Enhavo\Bundle\AppBundle\View;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Sylius\Bundle\ResourceBundle\Controller\ParametersParserInterface;
use Symfony\Component\Routing\RouterInterface;

class ViewConfigurationFactory
{
    /**
     * @var ParametersParserInterface
     */
    private $parametersParser;

    /**
     * @var string
     */
    private $configurationClass;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * ViewerUtil constructor.
     *
     * @param ParametersParserInterface $parametersParser
     * @param $configurationClass
     * @param RouterInterface $router
     */
    public function __construct(ParametersParserInterface $parametersParser, string $configurationClass, RouterInterface $router)
    {
        $this->parametersParser = $parametersParser;
        $this->configurationClass = $configurationClass;
        $this->router = $router;
    }

    public function createConfiguration(Request $request): ViewConfiguration
    {
        $viewParameters = $request->get('_view', []);
        $parameters = $this->parametersParser->parseRequestValues($viewParameters, $request);
        return new $this->configurationClass($request, new ParameterBag($parameters));
    }

    public function createConfigurationFromRoute($route): ViewConfiguration
    {
        $route = $this->router->getRouteCollection()->get($route);
        if($route === null) {
            return null;
        }

        $parameters = $route->getDefault('_view');
        $request = new Request();
        $parameters = $this->parametersParser->parseRequestValues($parameters, $request);
        return new $this->configurationClass($request, new ParameterBag($parameters));
    }
}