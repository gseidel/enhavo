<?php
/**
 * ItemFormType.php
 *
 * @since 06/05/15
 * @author gseidel
 */

namespace Enhavo\Bundle\GridBundle\Item;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

abstract class ItemFormType extends AbstractType
{
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if($options['form_name'] !== null) {
            $view->vars['full_name'] = sprintf('%s[itemType]', $options['form_name']);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translation' => false,
            'form_name' => null
        ]);
    }
}