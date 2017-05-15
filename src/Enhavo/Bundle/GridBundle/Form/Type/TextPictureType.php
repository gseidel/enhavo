<?php
/**
 * TextPictureType.php
 *
 */

namespace Enhavo\Bundle\GridBundle\Form\Type;

use Enhavo\Bundle\AppBundle\Form\Type\BooleanType;
use Enhavo\Bundle\AppBundle\Form\Type\WysiwygType;
use Enhavo\Bundle\GridBundle\Entity\TextPicture;
use Enhavo\Bundle\GridBundle\Item\ItemFormType;
use Enhavo\Bundle\MediaBundle\Form\Type\FilesType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextPictureType extends ItemFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class, array(
            'label' => 'form.label.title',
            'translation_domain' => 'EnhavoAppBundle',
            'translation' => $options['translation']
        ));

        $builder->add('text', WysiwygType::class, array(
            'label' => 'form.label.text',
            'translation_domain' => 'EnhavoAppBundle',
            'translation' => $options['translation']
        ));

        $builder->add('caption', TextType::class, array(
            'label' => 'textPicture.form.label.caption',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $options['translation']
        ));

        $builder->add('file', FilesType::class, array(
            'label' => 'form.label.picture',
            'translation_domain' => 'EnhavoAppBundle',
            'multiple' => false
        ));

        $builder->add('textLeft', BooleanType::class, array(
            'label' => 'textPicture.form.label.position',
            'translation_domain' => 'EnhavoGridBundle',
            'choices' => array(
                BooleanType::VALUE_FALSE => 'textPicture.form.label.picture_left-text_right',
                BooleanType::VALUE_TRUE => 'textPicture.form.label.text_left-picture_right'
            ),
            'expanded' => true,
            'multiple' => false
        ));

        $builder->add('float', BooleanType::class, array(
            'label' => 'textPicture.form.label.float',
            'translation_domain' => 'EnhavoGridBundle'
        ));

        $builder->add('layout', ChoiceType::class, array(
            'label' => 'textText.form.label.layout',
            'translation_domain' => 'EnhavoGridBundle',
            'choices'   => array(
                 'textPicture.form.label.1_1' => TextPicture::LAYOUT_1_1,
                 'textPicture.form.label.1_2' => TextPicture::LAYOUT_1_2,
                 'textPicture.form.label.2_1' => TextPicture::LAYOUT_2_1
            ),
            'expanded' => true,
            'multiple' => false
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => TextPicture::class
        ));
    }

    public function getName()
    {
        return 'enhavo_grid_item_text_picture';
    }
} 