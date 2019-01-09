<?php

namespace Enhavo\Bundle\AppBundle\View\Type;

use Enhavo\Bundle\AppBundle\Controller\RequestConfiguration;
use Enhavo\Bundle\AppBundle\View\ViewerUtil;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\ResourceBundle\Controller\RequestConfigurationFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BaseViewerTest extends TestCase
{
    private function createRequestConfigurationFactoryMock()
    {
        $mock = $this->getMockBuilder(RequestConfigurationFactoryInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $mock;
    }

    private function createViewerUtilMock()
    {
        $mock = $this->getMockBuilder(ViewerUtil::class)
            ->disableOriginalConstructor()
            ->getMock();
        return $mock;
    }

    public function testInitialize()
    {
        $requestConfigurationFactory = $this->createRequestConfigurationFactoryMock();
        $util = $this->createViewerUtilMock();
        $viewer = new BaseViewer($requestConfigurationFactory, $util);

        $this->assertInstanceOf(BaseViewer::class, $viewer);
    }

    public function testType()
    {
        $requestConfigurationFactory = $this->createRequestConfigurationFactoryMock();
        $util = $this->createViewerUtilMock();
        $viewer = new BaseViewer($requestConfigurationFactory, $util);

        $this->assertEquals('base', $viewer->getType());
    }

    public function testCreateView()
    {
        $containerMock = $this->getMockBuilder('Symfony\Component\DependencyInjection\ContainerInterface')->getMock();
        $containerMock->method('getParameter')->will($this->returnCallback(function($id) {
            if($id == 'enhavo_app.stylesheets') {
                return [
                    'path/to/style.css',
                    'path/to/admin.css',
                ];
            }
            if($id == 'enhavo_app.javascripts') {
                return [
                    'path/to/main.js',
                    'path/to/basic.js',
                ];
            }
            return [];
        }));

        $configurationMock = $this->getMockBuilder(RequestConfiguration::class)
            ->disableOriginalConstructor()
            ->getMock();
        $configurationMock->method('getViewerOptions')->willReturn([
            'stylesheets' => [
                'path/to/style.css',
                'path/to/admin.css',
            ],
            'javascripts' => [
                'path/to/main.js',
                'path/to/basic.js',
            ]
        ]);
        $configurationMock->method('getTemplate')->willReturn('template_path');
        $requestMock = $this->getMockBuilder(Request::class)->getMock();
        $requestConfigurationFactory = $this->createRequestConfigurationFactoryMock();
        $util = $this->createViewerUtilMock();

        $viewer = new BaseViewer($requestConfigurationFactory, $util);

        $viewer->setContainer($containerMock);

        $optionResolver = new OptionsResolver();
        $viewer->configureOptions($optionResolver);
        $options = $optionResolver->resolve([
            'request_configuration' => $configurationMock,
            'request' => $requestMock
        ]);

        $view = $viewer->createView($options);

        $this->assertInstanceOf('FOS\RestBundle\View\View', $view);

        $data = $view->getTemplateData();
        $this->assertArrayHasKey('javascripts', $data);
        $this->assertArrayHasKey('stylesheets', $data);
    }
}
