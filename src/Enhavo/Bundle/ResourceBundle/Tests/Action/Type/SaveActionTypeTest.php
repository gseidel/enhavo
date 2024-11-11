<?php
/**
 * Created by PhpStorm.
 * User: gseidel
 * Date: 2020-06-04
 * Time: 10:22
 */

namespace Enhavo\Bundle\ResourceBundle\Tests\Action\Type;

use Enhavo\Bundle\ResourceBundle\Action\Action;
use Enhavo\Bundle\ResourceBundle\Action\Type\SaveActionType;
use Enhavo\Bundle\ResourceBundle\RouteResolver\RouteResolverInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\RouterInterface;

class SaveActionTypeTest extends TestCase
{
    private function createDependencies(): SaveActionTypeDependencies
    {
        $dependencies = new SaveActionTypeDependencies();
        $dependencies->routeResolver = $this->getMockBuilder(RouteResolverInterface::class)->getMock();
        $dependencies->router = $this->getMockBuilder(RouterInterface::class)->getMock();
        return $dependencies;
    }

    private function createInstance(SaveActionTypeDependencies $dependencies): SaveActionType
    {
        return new SaveActionType(
            $dependencies->router,
            $dependencies->routeResolver,
        );
    }

    public function testCreateViewData()
    {
        $dependencies = $this->createDependencies();
        $dependencies->routeResolver->method('getRoute')->willReturn('save_route');
        $dependencies->router->method('generate')->willReturnCallback(function($name) {
            if ($name === 'save_route') {
                return '/save?id=1';
            }
            return null;
        });

        $instance = $this->createInstance($dependencies);

        $action = new Action($instance, [], []);

        $viewData = $action->createViewData();

        $this->assertEquals('/save?id=1', $viewData['url']);
    }

    public function testName()
    {
        $this->assertEquals('save', SaveActionType::getName());
    }
}

class SaveActionTypeDependencies
{
    public RouterInterface|MockObject $router;
    public RouteResolverInterface|MockObject $routeResolver;
}