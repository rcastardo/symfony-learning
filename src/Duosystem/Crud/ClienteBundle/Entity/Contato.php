<?php

namespace Duosystem\Crud\ClienteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contato
 *
 * @ORM\Table(name="clientes_contatos")
 * @ORM\Entity
 */
class Contato
{
    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="contatos")
     * @ORM\JoinColumn(name="id_cliente", referencedColumnName="id")
     */
    protected $cliente;

    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_contato", type="string", length=30)
     */
    private $tipo_contato;

    /**
     * @var string
     *
     * @ORM\Column(name="contato", type="string", length=150)
     */
    private $contato;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tipo_contato
     *
     * @param string $tipoContato
     * @return Contato
     */
    public function setTipoContato($tipoContato)
    {
        $this->tipo_contato = $tipoContato;
    
        return $this;
    }

    /**
     * Get tipo_contato
     *
     * @return string 
     */
    public function getTipoContato()
    {
        return $this->tipo_contato;
    }

    /**
     * Set contato
     *
     * @param string $contato
     * @return Contato
     */
    public function setContato($contato)
    {
        $this->contato = $contato;
    
        return $this;
    }

    /**
     * Get contato
     *
     * @return string 
     */
    public function getContato()
    {
        return $this->contato;
    }

    /**
     * Set cliente
     *
     * @param \Duosystem\Crud\ClienteBundle\Entity\Cliente $cliente
     * @return Contato
     */
    public function setCliente(\Duosystem\Crud\ClienteBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;
    
        return $this;
    }

    /**
     * Get cliente
     *
     * @return \Duosystem\Crud\ClienteBundle\Entity\Cliente
     */
    public function getCliente()
    {
        return $this->cliente;
    }
}