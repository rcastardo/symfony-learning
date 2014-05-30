<?php

namespace Duosystem\Crud\ClienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContatoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo_contato', 'choice', array(
                'required' => 'true',
                'empty_value' => 'Tipo de Contato',
                'choices' => array(
                    'Email' => 'Email',
                    'Telefone Residencial' => 'Telefone Residencial',
                    'Telefone Comercial' => 'Telefone Comercial',
                    'Celular' => 'Celular',
                ),
            ))
            ->add('contato')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Duosystem\Crud\ClienteBundle\Entity\Contato'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'duosystem_crud_clientebundle_contato';
    }
}
