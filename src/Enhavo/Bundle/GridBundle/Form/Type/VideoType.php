<?php

namespace Enhavo\Bundle\GridBundle\Form\Type;

use Enhavo\Bundle\GridBundle\Entity\Video;
use Symfony\Component\Form\FormBuilderInterface;
use Enhavo\Bundle\GridBundle\Item\ItemFormType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends ItemFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'text', array(
            'label' => 'form.label.title',
            'translation_domain' => 'EnhavoAppBundle',
            'translation' => $options['translation']
        ));

        $builder->add('url', 'text', array(
            'label' => 'video.form.label.url',
            'translation_domain' => 'EnhavoGridBundle'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => Video::class
        ));
    }

    public function getName()
    {
        return 'enhavo_grid_item_video';
    }
}