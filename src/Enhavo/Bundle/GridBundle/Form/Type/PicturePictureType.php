<?php
/**
 * TextType.php
 *
 * @since 23/08/14
 * @author Gerhard Seidel <gseidel.message@googlemail.com>
 */

namespace Enhavo\Bundle\GridBundle\Form\Type;

use Enhavo\Bundle\GridBundle\Entity\PicturePicture;
use Enhavo\Bundle\GridBundle\Item\ItemFormType;
use Enhavo\Bundle\MediaBundle\Form\Type\FilesType;
use Symfony\Component\Form\Extension\Core\Type\TextType as FormTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PicturePictureType extends ItemFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', FormTextType::class, array(
            'label' => 'form.label.title',
            'translation_domain' => 'EnhavoAppBundle',
            'translation' => $options['translation']
        ));

        $builder->add('fileLeft', FilesType::class, array(
            'label' => 'picturePicture.form.label.picture_left',
            'translation_domain' => 'EnhavoGridBundle',
            'multiple' => false
        ));

        $builder->add('captionLeft', FormTextType::class, array(
            'label' => 'picturePicture.form.label.caption_left',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $options['translation']
        ));

        $builder->add('fileRight', FilesType::class, array(
            'label' => 'picturePicture.form.label.picture_right',
            'translation_domain' => 'EnhavoGridBundle',
            'multiple' => false
        ));

        $builder->add('captionRight', FormTextType::class, array(
            'label' => 'picturePicture.form.label.caption_right',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $options['translation']
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => PicturePicture::class
        ));
    }

    public function getName()
    {
        return 'enhavo_grid_item_picture_picture';
    }

    public function getBlockPrefix()
    {
        return $this->getName();
    }
} 