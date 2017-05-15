<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Enhavo\Bundle\AppBundle\Controller;

use Sylius\Bundle\ResourceBundle\Controller\ParametersParser;
use Sylius\Bundle\ResourceBundle\Controller\Parameters;
use Symfony\Component\HttpFoundation\Request;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfigurationFactoryInterface;
use Symfony\Component\Routing\RouterInterface;
use Sylius\Component\Resource\Metadata\MetadataInterface;

class RequestConfigurationFactory implements SimpleRequestConfigurationFactoryInterface, RequestConfigurationFactoryInterface
{
    const API_VERSION_HEADER = 'Accept';
    const API_GROUPS_HEADER = 'Accept';

    const API_VERSION_REGEXP = '/(v|version)=(?P<version>[0-9\.]+)/i';
    const API_GROUPS_REGEXP = '/(g|groups)=(?P<groups>[a-z,_\s]+)/i';

    /**
     * @var ParametersParser
     */
    private $parametersParser;

    /**
     * @var string
     */
    private $configurationClass;

    /**
     * @var array
     */
    private $defaultParameters;

    /**
     * @var string
     */
    private $simpleConfigurationClass;

    /**
     * @param ParametersParser $parametersParser
     * @param string $configurationClass
     * @param array $defaultParameters
     * @param string $simpleConfigurationClass
     */
    public function __construct(
        ParametersParser $parametersParser,
        $configurationClass,
        array $defaultParameters,
        $simpleConfigurationClass
    )
    {
        $this->parametersParser = $parametersParser;
        $this->configurationClass = $configurationClass;
        $this->defaultParameters = $defaultParameters;
        $this->simpleConfigurationClass = $simpleConfigurationClass;
    }

    /**
     * {@inheritdoc}
     */
    public function createSimple(Request $request)
    {
        $parameters = array_merge($this->defaultParameters, $request->attributes->get('_sylius', []));
        $parameters = $this->parametersParser->parseRequestValues($parameters, $request);
        return new $this->simpleConfigurationClass($request, new Parameters($parameters));
    }

    public function createFromRoute($route, MetadataInterface $metadata, RouterInterface $router)
    {
        $route = $router->getRouteCollection()->get($route);
        if($route === null) {
            return null;
        }
        $parameters = $route->getDefault('_sylius');
        $request = new Request();
        $parameters = array_merge($this->defaultParameters, $parameters);
        $parameters = $this->parametersParser->parseRequestValues($parameters, $request);
        return new $this->configurationClass($metadata, $request, new Parameters($parameters));
    }
    
    /**
     * {@inheritdoc}
     */
    public function create(MetadataInterface $metadata, Request $request)
    {
        $parameters = array_merge($this->defaultParameters, $this->parseApiParameters($request));
        $parameters = $this->parametersParser->parseRequestValues($parameters, $request);

        return new $this->configurationClass($metadata, $request, new Parameters($parameters));
    }

    /**
     * @param Request $request
     *
     * @return array
     *
     * @throws \InvalidArgumentException
     */
    private function parseApiParameters(Request $request)
    {
        $parameters = [];

        if (preg_match(self::API_VERSION_REGEXP, $request->headers->get(self::API_VERSION_HEADER), $matches)) {
            $parameters['serialization_version'] = $matches['version'];
        }

        if (preg_match(self::API_GROUPS_REGEXP, $request->headers->get(self::API_GROUPS_HEADER), $matches)) {
            $parameters['serialization_groups'] = array_map('trim', explode(',', $matches['groups']));
        }

        return array_merge($request->attributes->get('_sylius', []), $parameters);
    }
}
