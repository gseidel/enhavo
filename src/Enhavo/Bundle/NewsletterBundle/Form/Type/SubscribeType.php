<?php

namespace Enhavo\Bundle\NewsletterBundle\Form\Type;

use Enhavo\Bundle\NewsletterBundle\Entity\Subscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubscribeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', TextType::class, array(
            'label' => 'subscriber.form.label.email',
            'translation_domain' => 'EnhavoNewsletterBundle'
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Subscriber::class
        ));
    }

    public function getName()
    {
        return 'enhavo_newsletter_subscribe';
    }
}