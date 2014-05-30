<?php

namespace Duosystem\Crud\ClienteBundle\Twig;

class ClienteExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('fotos_path', array($this, 'fotosPath')),
        );
    }

    /**
     * $sizes: 1 = small, 2 = medium, 3 = big
     */
    public function fotosPath($name, $size = 2, $format = 'jpg')
    {
        return $renderPath = '/bundles/cliente/uploads/fotos/'.$name;
    }

    public function getName()
    {
        return 'cliente_extension';
    }
}