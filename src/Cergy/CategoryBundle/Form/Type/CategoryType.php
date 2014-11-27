<?php
/**
 * Created by PhpStorm.
 * User: BARBARIN
 * Date: 27/11/2014
 * Time: 14:33
 */

namespace Cergy\CategoryBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*Can't post if you haven't inform them value*/
        $builder -> add('label', 'text', [
            'required' => true,
            'max_length' => 100,
            'label' => 'Label'
        ]);

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Cergy\CategoryBundle\Entity\Category'
        ]);
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'category';
    }
} 