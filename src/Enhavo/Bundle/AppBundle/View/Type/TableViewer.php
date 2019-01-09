<?php
/**
 * TableViewer.php
 *
 * @since 29/05/15
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\View\Type;

use Enhavo\Bundle\AppBundle\View\ViewConfiguration;
use Enhavo\Bundle\AppBundle\View\ViewConfigurationFactory;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TableViewer extends ResourceViewer
{
    /**
     * @var ViewConfigurationFactory
     */
    private $viewConfigurationFactory;

    public function __construct(ViewConfigurationFactory $viewConfigurationFactory)
    {
        $this->viewConfigurationFactory = $viewConfigurationFactory;
    }

    public function getType()
    {
        return 'table';
    }

    private function getColumns($options, ViewConfiguration $configuration, $defaultTranslationDomain = null)
    {
        $columns = $configuration->get('columns');
        $requestConfiguration = $this->getRequestConfiguration($options);

        if(empty($columns)) {
            if ($requestConfiguration->isSortable()) {
                $columns = array(
                    'id' => array(
                        'label' => 'id',
                        'property' => 'id',
                    ),
                    'position' => array(
                        'type' => 'position'
                    )
                );
            } else {
                $columns = array(
                    'id' => array(
                        'label' => 'id',
                        'property' => 'id',
                    )
                );
            }
        }

        foreach($columns as $key => &$column) {
            if(!array_key_exists('type', $column)) {
                $column['type'] = 'property';
            }
        }

        foreach($columns as $key => &$column) {
            if(!array_key_exists('translationDomain', $column)) {
                $column['translationDomain'] = $defaultTranslationDomain;
            }
        }

        return $columns;
    }
    
    private function getBatches($batchRoute)
    {
        $configuration = $this->viewConfigurationFactory->createConfigurationFromRoute($batchRoute);
        return $configuration->getArray('batches');
    }

    protected function buildTemplateParameters(ParameterBag $parameters, ViewConfiguration $viewConfiguration, array $options)
    {
        parent::buildTemplateParameters($parameters, $viewConfiguration, $options);

        $metadata = $this->getMetadata($options);
        $requestConfiguration = $this->getRequestConfiguration($options);

        $parameters->set('sortable', $requestConfiguration->isSortable());

        $parameters->set('columns', $viewConfiguration->getArray('columns', [
            $options['columns'],
            $this->getColumns($options, $viewConfiguration, $parameters->get('translationDomain'))
        ]));

        $parameters->set('batch_route', $viewConfiguration->getArray('columns', [
            sprintf('%s_%s_batch', $metadata->getApplicationName(), $this->getUnderscoreName($metadata)),
            $options['batch_route'],
        ]));

        $parameters->set('batch_route', $viewConfiguration->getArray('batch_route', [
            sprintf('%s_%s_batch', $metadata->getApplicationName(), $this->getUnderscoreName($metadata)),
            $options['batch_route'],
        ]));

        $parameters->set('batches', $this->getBatches($parameters->get('batch_route')));

        $parameters->set('width', $viewConfiguration->get('width', [
            $options['width']
        ]));

        $parameters->set('move_after_route', $viewConfiguration->get('move_after_route', [
            sprintf('%s_%s_move_after', $metadata->getApplicationName(), $this->getUnderscoreName($metadata)),
            $options['move_after_route']
        ]));

        $parameters->set('move_to_page_route', $viewConfiguration->get('move_to_page_route', [
            sprintf('%s_%s_move_to_page', $metadata->getApplicationName(), $this->getUnderscoreName($metadata)),
            $options['move_to_page_route']
        ]));
    }

    public function configureOptions(OptionsResolver $optionsResolver)
    {
        parent::configureOptions($optionsResolver);
        $optionsResolver->setDefaults([
            'width' => 12,
            'move_after_route' => null,
            'move_to_page_route' => null,
            'batch_route' => null,
            'columns' => [],
            'template' => 'EnhavoAppBundle:Viewer:table.html.twig'
        ]);
    }
}
