<?php
/**
 * TextTextType.php
 *
 */

namespace Enhavo\Bundle\GridBundle\Form\Type;

use Enhavo\Bundle\AppBundle\Form\Type\WysiwygType;
use Enhavo\Bundle\GridBundle\Item\ItemFormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Enhavo\Bundle\GridBundle\Entity\TextText;

class TextTextType extends ItemFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
            'label' => 'form.label.title',
            'translation_domain' => 'EnhavoAppBundle',
            'translation' => $options['translation']
        ));

        $builder->add('titleLeft', TextType::class, array(
            'label' => 'textText.form.label.title_left',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $options['translation']
        ));

        $builder->add('textLeft', WysiwygType::class, array(
            'label' => 'textText.form.label.text_left',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $options['translation']
        ));

        $builder->add('titleRight', TextType::class, array(
            'label' => 'textText.form.label.title_right',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $options['translation']
        ));

        $builder->add('textRight', WysiwygType::class, array(
            'label' => 'textText.form.label.text_right',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $options['translation']
        ));

        $builder->add('layout', ChoiceType::class, array(
            'label' => 'textText.form.label.layout',
            'translation_domain' => 'EnhavoGridBundle',
            'choices' => array(
                 'textText.form.label.1_1' => TextText::LAYOUT_1_1,
                 'textText.form.label.1_2' => TextText::LAYOUT_1_2,
                 'textText.form.label.2_1' => TextText::LAYOUT_2_1
            ),
            'expanded' => true,
            'multiple' => false
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => TextText::class
        ));
    }

    public function getName()
    {
        return 'enhavo_grid_item_text_text';
    }
} 