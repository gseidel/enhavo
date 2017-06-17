<?php

namespace Enhavo\Bundle\DownloadBundle\Form\Type;

use Enhavo\Bundle\AppBundle\Form\Type\WysiwygType;
use Enhavo\Bundle\MediaBundle\Form\Type\FilesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use Enhavo\Bundle\DownloadBundle\Entity\Download;

class DownloadType extends AbstractType
{
    protected $dataClass;

    /**
     * @var boolean
     */
    protected $translation;

    public function __construct($dataClass, $translation, $router)
    {
        $this->dataClass = $dataClass;
        $this->translation = $translation;
        $this->router = $router;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) use ($options) {
            $data = $event->getData();
            $form = $event->getForm();

            if ($data instanceof Download && !empty($data->getId())) {
                $form->add('link', TextType::class, array(
                    'mapped' => false,
                    'data' => $this->router->generate('enhavo_media_download', array(
                        'id' => $data->getId()
                    ), true),
                    'disabled' => true
                ));
            }
        });

        $builder->add('title', TextType::class, array(
            'label' => 'form.label.title',
            'translation_domain' => 'EnhavoAppBundle',
            'translation' => $this->translation
        ));

        $builder->add('text', WysiwygType::class, array(
            'label' => 'form.label.text',
            'translation_domain' => 'EnhavoAppBundle',
            'translation' => $this->translation
        ));

        $builder->add('file', FilesType::class, array(
            'label' => 'download.form.label.file',
            'translation_domain' => 'EnhavoDownloadBundle',
            'multiple'  => false
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->dataClass
        ));
    }

    public function getName()
    {
        return 'enhavo_download_download';
    }
}