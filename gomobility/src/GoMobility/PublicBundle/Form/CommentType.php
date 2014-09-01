<?php

namespace GoMobility\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CommentType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', 'choice', array(
                    'choices' => array(
                        'publié' => 'publié',
                        'non publié' => 'non publié'
                    ),
                    'empty_value' => 'Choisissez le status',
                    'required'    => false,
                    'data' => 'non publié'
                )) 
            ->add('nom')
            ->add('email')
            ->add('message')          
            ->add('date','datetime', array(
                'required' => false,
                'with_minutes' => true,
                'with_seconds' => true,
                'format' => 'ddMMyyyy',
                'empty_value' => array('year' => 'Année', 'month' => 'Mois', 'day' => 'Jour'),
                'data'  => date_create()
                ))    
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GoMobility\PublicBundle\Entity\Comment'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gomobility_publicbundle_comments';
    }
}
