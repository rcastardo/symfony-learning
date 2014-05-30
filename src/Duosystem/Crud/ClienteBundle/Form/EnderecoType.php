<?php

namespace Duosystem\Crud\ClienteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EnderecoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('logradouro')
            ->add('numero')
            ->add('complemento')
            ->add('cep')
            ->add('bairro')
            ->add('cidade')
            ->add('estado', 'choice', array(
                    'required' => 'true',
                    'empty_value' => 'Estado',
                    'choices' => array(
                        'AC' => 'Acre',
                        'AL' => 'Alagoas',
                        'AP' => 'Amapá',
                        'AM' => 'Amazonas',
                        'BA' => 'Bahia',
                        'CE' => 'Ceará',
                        'DF' => 'Distrito Federal',
                        'ES' => 'Espirito Santo',
                        'GO' => 'Goiás',
                        'MA' => 'Maranhão',
                        'MS' => 'Mato Grosso do Sul',
                        'MT' => 'Mato Grosso',
                        'MG' => 'Minas Gerais',
                        'PA' => 'Pará',
                        'PB' => 'Paraíba',
                        'PR' => 'Paraná',
                        'PE' => 'Pernambuco',
                        'PI' => 'Piauí',
                        'RJ' => 'Rio de Janeiro',
                        'RN' => 'Rio Grande do Norte',
                        'RS' => 'Rio Grande do Sul',
                        'RO' => 'Rondônia',
                        'RR' => 'Roraima',
                        'SC' => 'Santa Catarina',
                        'SP' => 'São Paulo',
                        'SE' => 'Sergipe',
                        'TO' => 'Tocantins',
                    ),
                )
            );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Duosystem\Crud\ClienteBundle\Entity\Endereco'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'duosystem_crud_clientebundle_endereco';
    }
}
