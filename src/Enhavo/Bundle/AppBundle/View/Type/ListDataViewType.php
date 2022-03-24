<?php
/**
 * ListDataViewer.php
 *
 * @since 22/04/19
 * @author gseidel
 */

namespace Enhavo\Bundle\AppBundle\View\Type;

use Enhavo\Bundle\AppBundle\Column\ColumnManager;
use Enhavo\Bundle\AppBundle\Controller\SortingManager;
use Enhavo\Bundle\AppBundle\View\AbstractViewType;
use Enhavo\Bundle\AppBundle\View\TemplateData;
use Enhavo\Bundle\AppBundle\View\ViewData;
use Enhavo\Bundle\AppBundle\View\ViewUtil;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Csrf\CsrfTokenManager;
use Symfony\Contracts\Translation\TranslatorInterface;

class ListDataViewType extends AbstractViewType
{
    public function __construct(
        private ViewUtil $util,
        private ColumnManager $columnManager,
        private TranslatorInterface $translator,
        private SortingManager $sortingManager,
        private CsrfTokenManager $tokenManager
    ) {}

    public static function getName(): ?string
    {
        return 'list_data';
    }

    public static function getParentType(): ?string
    {
        return AppViewType::class;
    }

    public function handleRequest($options, Request $request, ViewData $viewData, TemplateData $templateData)
    {
        $request->query->set('limit', 1000000); // never show pagination
        $configuration = $this->util->getRequestConfiguration($options);

        if ($request->getMethod() === 'POST') {
            if ($configuration->isCsrfProtectionEnabled() && !$this->isCsrfTokenValid('list_data', $request->get('_csrf_token'))) {
                throw new HttpException(Response::HTTP_FORBIDDEN, 'Invalid csrf token.');
            }
            $this->sortingManger->handleSort($request, $configuration, $this->repository);
            return new JsonResponse();
        }
    }

    public function createTemplateData($options, ViewData $data, TemplateData $templateData)
    {
        $requestConfiguration = $this->util->getRequestConfiguration($options);

        $columns = $this->util->mergeConfigArray([
            $options['columns'],
            $this->util->getViewerOption('columns', $requestConfiguration)
        ]);

        $childrenProperty = $this->util->mergeConfig([
            $options['children_property'],
            $this->util->getViewerOption('children_property', $requestConfiguration)
        ]);

        $positionProperty = $this->util->mergeConfig([
            $options['position_property'],
            $this->util->getViewerOption('position_property', $requestConfiguration)
        ]);

        $token = $this->tokenManager->getToken('list_data');
        $templateData['token'] = $token->getValue();
        $templateData['resources'] = $this->columnManager->createResourcesViewData($columns, $options['resources'], $childrenProperty, $positionProperty);
    }

    public function configureOptions(OptionsResolver $optionsResolver)
    {
        $optionsResolver->setDefaults([
            'template' => 'admin/view/data.html.twig',
            'columns' => [],
            'children_property' => null,
            'position_property' => null,
            'resources' => null,
            'request_configuration' => null,
            'metadata' => null,
        ]);
    }
}