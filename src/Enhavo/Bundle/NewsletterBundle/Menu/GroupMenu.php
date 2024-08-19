<?php
/**
 * Created by PhpStorm.
 * User: philippsester
 * Date: 19.08.19
 * Time: 15:21
 */

namespace Enhavo\Bundle\NewsletterBundle\Menu;

use Enhavo\Bundle\AppBundle\Menu\AbstractMenuType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupMenu extends AbstractMenuType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'icon' => 'add_box',
            'label' => 'group.label.group',
            'translation_domain' => 'EnhavoNewsletterBundle',
            'route' => 'enhavo_newsletter_group_index',
            'role' => 'ROLE_ENHAVO_NEWSLETTER_GROUP_INDEX',
        ]);
    }

    public static function getName(): ?string
    {
        return 'newsletter_group';
    }
}
