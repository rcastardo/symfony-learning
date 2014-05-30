<?php

namespace Duosystem\Crud\ClienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClienteType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file')
            ->add('nome')
            ->add('rg')
            ->add('cpf')

            ->add('data_nascimento', 'date', array(
                'required' => false,
                'widget' => 'single_text'
            ))
           ->add('idade')
            ->add('sexo', 'choice',
                array(
                    'required' => false,
                    'empty_value' => 'Sexo',
                    'choices' =>
                    array(
                        'M' => 'Masculino',
                        'F' => 'Feminino',
                        'O' => 'Outros'
                    ),
                )
            )

            ->add('enderecos', 'collection',
                array (
                    'type' => new EnderecoType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,
                ),
                array(
                    'label' => false
                )
            )

            ->add('contatos', 'collection',
                array (
                    'type' => new ContatoType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false,

                ),
                array (
                    'label' => false
                )
            )
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Duosystem\Crud\ClienteBundle\Entity\Cliente',
            'cascade_validation' => true,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'duosystem_crud_clientebundle_cliente';
    }
}
