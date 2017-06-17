<?php
/**
 * PictureType.php
 *
 * @since 23/08/14
 * @author Gerhard Seidel <gseidel.message@googlemail.com>
 */

namespace Enhavo\Bundle\GridBundle\Form\Type;

use Enhavo\Bundle\GridBundle\Entity\Picture;
use Enhavo\Bundle\GridBundle\Item\ItemFormType;
use Enhavo\Bundle\MediaBundle\Form\Type\FilesType;
use Symfony\Component\Form\Extension\Core\Type\TextType as FormTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PictureType extends ItemFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', FormTextType::class, array(
            'label' => 'form.label.title',
            'translation_domain' => 'EnhavoAppBundle',
            'translation' => $options['translation']
        ));

        $builder->add('file', FilesType::class, array(
            'label' => 'form.label.picture',
            'translation_domain' => 'EnhavoAppBundle',
            'multiple' => false
        ));

        $builder->add('caption', FormTextType::class, array(
            'label' => 'picture.form.label.caption',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $options['translation']
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => Picture::class
        ));
    }

    public function getName()
    {
        return 'enhavo_grid_item_picture';
    }

    public function getBlockPrefix()
    {
        return $this->getName();
    }
} 