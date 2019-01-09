<?php
/**
 * ViewerFactory.php
 *
 * @since 28/05/15
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\View;

use Enhavo\Bundle\AppBundle\Type\TypeCollector;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\Exception\InvalidArgumentException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ViewFactory
{
    /**
     * @var TypeCollector
     */
    private $collector;

    /**
     * @var ViewConfigurationFactory
     */
    private $configurationFactory;

    /**
     * ViewFactory constructor.
     *
     * @param TypeCollector $collector
     * @param ViewConfigurationFactory $configurationFactory
     */
    public function __construct(TypeCollector $collector, ViewConfigurationFactory $configurationFactory)
    {
        $this->collector = $collector;
        $this->configurationFactory = $configurationFactory;
    }

    public function create($type, Request $request, $options = []): View
    {
        $configuration = $this->configurationFactory->createConfiguration($request);

        if($configuration->getType()) {
            $type = $configuration->getType();
        }

        /** @var ViewTypeInterface $viewType */
        $viewType = $this->collector->getType($type);
        $resolver = new OptionsResolver();
        $viewType->configureOptions($resolver);
        try {
            $view = $viewType->createView($configuration, $resolver->resolve($options));
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException(sprintf(
                'Invalid arguments for view type "%s" with message: %s',
                $type,
                $e->getMessage()
            ));
        }

        return $view;
    }
}