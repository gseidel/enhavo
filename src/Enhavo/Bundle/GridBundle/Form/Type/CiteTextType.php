<?php
/**
 * CiteTextType.php
 *
 */

namespace Enhavo\Bundle\GridBundle\Form\Type;

use Enhavo\Bundle\GridBundle\Entity\CiteText;
use Enhavo\Bundle\GridBundle\Item\ItemFormType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CiteTextType extends ItemFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('cite', TextareaType::class, array(
            'label' => 'citeText.form.label.cite',
            'translation_domain' => 'EnhavoGridBundle',
            'translation' => $options['translation']
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults(array(
            'data_class' => CiteText::class
        ));
    }

    public function getName()
    {
        return 'enhavo_grid_item_citetext';
    }
} 