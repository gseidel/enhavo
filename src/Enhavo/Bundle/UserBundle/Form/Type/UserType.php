<?php
/**
 * UserType.php
 *
 * @since 04/08/14
 * @author Gerhard Seidel <gseidel.message@googlemail.com>
 */

namespace Enhavo\Bundle\UserBundle\Form\Type;

use Enhavo\Bundle\AppBundle\Form\Type\BooleanType;
use Enhavo\Bundle\UserBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, array(
            'label' => 'user.form.label.username',
            'translation_domain' => 'EnhavoUserBundle'
        ));

        $builder->add('plainPassword', RepeatedType::class, array(
            'type' => PasswordType::class,
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => 'form.password'),
            'second_options' => array('label' => 'form.password_confirmation'),
            'invalid_message' => 'fos_user.password.mismatch',
        ));

        $builder->add('email', TextType::class, array(
            'label' => 'user.form.label.email',
            'translation_domain' => 'EnhavoUserBundle'
        ));

        $builder->add('firstName', TextType::class, array(
            'label' => 'user.form.label.firstName',
            'translation_domain' => 'EnhavoUserBundle'
        ));

        $builder->add('lastName', TextType::class, array(
            'label' => 'user.form.label.lastName',
            'translation_domain' => 'EnhavoUserBundle'
        ));

        $builder->add('admin', BooleanType::class, array(
            'label' => 'user.form.label.admin',
            'translation_domain' => 'EnhavoUserBundle'
        ));

        $builder->add('groups', EntityType::class, array(
            'class' => 'EnhavoUserBundle:Group',
            'choice_label' => 'name',
            'multiple' => true,
            'expanded' => true,
            'attr' => array('class' => 'choice-list'),
            'label' => 'user.form.label.groups',
            'translation_domain' => 'EnhavoUserBundle'
        ));
    }

    public function getDefaultOptions()
    {
        return array(
            'data_class' => User::class
        );
    }

    public function getName()
    {
        return 'enhavo_user_user';
    }
}