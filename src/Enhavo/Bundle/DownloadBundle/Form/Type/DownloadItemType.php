<?php

namespace Enhavo\Bundle\DownloadBundle\Form\Type;

use Enhavo\Bundle\DownloadBundle\Entity\DownloadItem;
use Enhavo\Bundle\MediaBundle\Form\Type\FilesType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Enhavo\Bundle\GridBundle\Item\ItemFormType;

class DownloadItemType extends ItemFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('download', EntityType::class, array(
            'class' => 'Enhavo\Bundle\DownloadBundle\Entity\Download',
            'property' => 'title',
            'multiple' => false,
            'expanded' => false,
            'empty_value' => 'downloadItem.label.download.item.choose',
            'label' => 'downloadItem.form.label.download',
            'translation_domain' => 'EnhavoDownloadBundle',
        ));

        $builder->add('title', TextType::class, array(
            'label' => 'form.label.title',
            'translation_domain' => 'EnhavoAppBundle',
            'translation' => $this->translation
        ));

        $builder->add('file', FilesType::class, array(
            'label' => 'downloadItem.form.label.file',
            'translation_domain' => 'EnhavoDownloadBundle',
            'multiple'  => false
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => DownloadItem::class
        ));
    }

    public function getName()
    {
        return 'enhavo_download_item_download';
    }
}