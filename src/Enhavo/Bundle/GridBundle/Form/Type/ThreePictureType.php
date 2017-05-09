<?php
/**
 * TextType.php
 *
 * @since 23/08/14
 * @author Gerhard Seidel <gseidel.message@googlemail.com>
 */

namespace Enhavo\Bundle\GridBundle\Form\Type;

use Enhavo\Bundle\GridBundle\Entity\ThreePicture;
use Enhavo\Bundle\GridBundle\Item\ItemFormType;
use Enhavo\Bundle\MediaBundle\Form\Type\FilesType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ThreePictureType extends ItemFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titleLeft', TextType::class, array(
            'label' => 'threePicture.form.label.title_left',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $this->translation
        ));

        $builder->add('fileLeft', FilesType::class, array(
            'label' => 'threePicture.form.label.picture_left',
            'translation_domain' => 'EnhavoGridBundle',
            'multiple' => false
        ));

        $builder->add('captionLeft', TextType::class, array(
            'label' => 'threePicture.form.label.caption_left',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $this->translation
        ));

        $builder->add('titleCenter', TextType::class, array(
            'label' => 'threePicture.form.label.title_center',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $this->translation
        ));

        $builder->add('fileCenter', FilesType::class, array(
            'label' => 'threePicture.form.label.picture_center',
            'translation_domain' => 'EnhavoGridBundle',
            'multiple' => false
        ));

        $builder->add('captionCenter', TextType::class, array(
            'label' => 'threePicture.form.label.caption_center',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $this->translation
        ));

        $builder->add('titleRight', TextType::class, array(
            'label' => 'threePicture.form.label.title_right',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $this->translation
        ));

        $builder->add('fileRight', FilesType::class, array(
            'label' => 'threePicture.form.label.picture_right',
            'translation_domain' => 'EnhavoGridBundle',
            'multiple' => false
        ));

        $builder->add('captionRight', TextType::class, array(
            'label' => 'threePicture.form.label.caption_right',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $this->translation
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ThreePicture::class
        ));
    }

    public function getName()
    {
        return 'enhavo_grid_item_three_picture';
    }
} 