<?php
/**
 * Created by PhpStorm.
 * User: BARBARIN
 * Date: 27/11/2014
 * Time: 14:33
 */

namespace Cergy\BookBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*Can't post if you haven't inform them value*/
        $builder -> add('title', 'text', [
            'required' => true,
            'max_length' => 100,
            'label' => 'Title'
        ])
        -> add('description', 'textarea', [
            'required' => true,
            'label' => 'Description'
        ])
        -> add('publishAt', 'date',[
            'required' => true,
            'label' => 'Publicated Date'
        ])
        ->add('author', 'entity', [
            'class' => 'Cergy\UsersBundle\Entity\User',
            'property' => 'username',
            'required' => true,
            'label' => 'Author'
        ])
        ->add('price', 'money', [
            'required' => true,
            'label' => 'Price'
        ])
        ->add('category', 'entity',[
            'class' => 'Cergy\CategoryBundle\Entity\Category',
            'property' => 'label',
            'required' => true,
            'label' => 'Category'
        ]);

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Cergy\BookBundle\Entity\Book'
        ]);
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'book';
    }
} 