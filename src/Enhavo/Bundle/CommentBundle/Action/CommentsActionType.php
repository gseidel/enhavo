<?php
/**
 * Created by PhpStorm.
 * User: gseidel
 * Date: 2019-10-26
 * Time: 12:42
 */

namespace Enhavo\Bundle\CommentBundle\Action;

use Enhavo\Bundle\ApiBundle\Data\Data;
use Enhavo\Bundle\CommentBundle\Exception\CommentSubjectException;
use Enhavo\Bundle\CommentBundle\Model\CommentSubjectInterface;
use Enhavo\Bundle\ResourceBundle\Action\AbstractActionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\RouterInterface;

class CommentsActionType extends AbstractActionType
{
    public function __construct(
        private readonly RouterInterface $router,
    )
    {
    }

    public function createViewData(array $options, Data $data, object $resource = null): void
    {
        if (!$resource instanceof CommentSubjectInterface) {
            throw CommentSubjectException::createTypeException($resource);
        }

        $url = $this->router->generate($options['route'], [
            'id' => $resource->getThread()->getId()
        ]);

        $data['url'] = $url;
        $data['target'] = '_frame';
        $data['key'] = 'comment-view';
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'component' => 'open-action',
            'model' => 'OpenAction',
            'route' => 'enhavo_comment_admin_comment_index',
            'label' => 'comment.label.comments',
            'translation_domain' => 'EnhavoCommentBundle',
            'icon' => 'comment'
        ]);
    }

    public static function getName(): ?string
    {
        return 'comments';
    }
}
