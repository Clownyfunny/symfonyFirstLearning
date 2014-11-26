<?php
/**
 * Created by PhpStorm.
 * User: BARBARIN
 * Date: 25/11/2014
 * Time: 14:53
 */
namespace Cergy\NewsBundle\Form\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*Can't post if you haven't inform them value*/
        $builder -> add('title', 'text', [
            'required' => true,
            'max_length' => 100,
            'label' => 'Title'
        ]);
        $builder -> add('content', 'textarea', [
            'required' => true,
            'label' => 'Content'
        ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Cergy\NewsBundle\Entity\News'
        ]);
    }
    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'news';
    }
}