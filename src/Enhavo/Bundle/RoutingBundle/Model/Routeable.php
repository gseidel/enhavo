<?php
/**
 * Routeable.php
 *
 * @since 16/05/16
 * @author gseidel
 */

namespace Enhavo\Bundle\RoutingBundle\Model;

interface Routeable
{
    /**
     * @return RouteInterface
     */
    public function getRoute();

    /**
     * @param RouteInterface $route
     * @return mixed
     */
    public function setRoute(RouteInterface $route);
}