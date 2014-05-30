<?php

namespace Duosystem\Crud\ClienteBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToLocalizedStringTransformer;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
/**
 * Cliente
 *
 * @ORM\Table(name="clientes")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Entity(repositoryClass="Duosystem\Crud\ClienteBundle\Repository\ClienteRepository")
 */
class Cliente
{
    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;

    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path
            ? null
            : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../Duosystem/Crud/ClienteBundle/Resources/public/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return 'uploads/fotos';
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->path = $filename.'.'.$this->file->guessExtension();
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }


    /**
     * @ORM\OneToMany(targetEntity="Contato", mappedBy="cliente", cascade={"all"}))
     */
    protected $contatos;

    /**
     * @return mixed
     */
    public function getContatos()
    {
        return $this->contatos;
    }

    /**
     * @ORM\OneToMany(targetEntity="Endereco", mappedBy="cliente", cascade={"all"})
     */
    protected $enderecos;

    public function __construct()
    {
        $this->enderecos = new ArrayCollection();
        $this->contatos = new ArrayCollection();
    }

    /**
     * Get enderecos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnderecos()
    {
        return $this->enderecos;
    }



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
     * @ORM\Column(name="nome", type="string", length=150)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "3",
     *      max = "150",
     *      minMessage = "Seu nome não pode conter menos que {{ limit }} caracteres.",
     *      maxMessage = "Seu nome não pode conter mais que {{ limit }} caracteres."
     * )

     */
    private $nome;

    /**
     * @var integer
     *
     * @ORM\Column(name="idade", type="integer", nullable=true)
     *
     */
    private $idade;

    /**
     * @var date
     *
     * @ORM\Column(name="data_nascimento", type="date", nullable=true)
     */
    private $data_nascimento;

    /**
     * @param string $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @param \Duosystem\Crud\ClienteBundle\Entity\date $data_nascimento
     */
    public function setDataNascimento($data_nascimento)
    {
        $this->data_nascimento = $data_nascimento;
    }

    /**
     * @return \Duosystem\Crud\ClienteBundle\Entity\date
     */
    public function getDataNascimento()
    {
        return $this->data_nascimento;
    }

    /**
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }


    /**
     * @param string $rg
     */
    public function setRg($rg)
    {
        $this->rg = $rg;
    }

    /**
     * @return string
     */
    public function getRg()
    {
        return $this->rg;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="rg", type="string", nullable=true, length=20)
     */
    private $rg;

    /**
     * @var string
     *
     * @ORM\Column(name="cpf", type="string", nullable=true, length=20)
     */
    private $cpf;

    /**
     * @var string
     *
     * @ORM\Column(name="sexo", type="string", length=20, nullable=true)
     */
    private $sexo;



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
     * Set nome
     *
     * @param string $nome
     * @return Cliente
     */
    public function setNome($nome)
    {
        $this->nome = $nome;
    
        return $this;
    }

    /**
     * Get nome
     *
     * @return string 
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set idade
     *
     * @param integer $idade
     * @return Cliente
     */
    public function setIdade($idade)
    {
        $this->idade = $idade;
    
        return $this;
    }

    /**
     * Get idade
     *
     * @return integer 
     */
    public function getIdade()
    {
        return $this->idade;
    }

    /**
     * Set sexo
     *
     * @param string $sexo
     * @return Cliente
     */
    public function setSexo($sexo)
    {
        $this->sexo = $sexo;
    
        return $this;
    }

    /**
     * Get sexo
     *
     * @return string 
     */
    public function getSexo()
    {
        return $this->sexo;
    }



    /**
     * Add enderecos
     *
     * @param \Duosystem\Crud\ClienteBundle\Entity\Endereco $enderecos
     * @return Cliente
     */
    public function addEndereco(\Duosystem\Crud\ClienteBundle\Entity\Endereco $enderecos)
    {
        $enderecos->setCliente($this);
        $this->enderecos[] = $enderecos;
    
        return $this;
    }

    /**
     * Remove enderecos
     *
     * @param \Duosystem\Crud\ClienteBundle\Entity\Endereco $enderecos
     */
    public function removeEndereco(\Duosystem\Crud\ClienteBundle\Entity\Endereco $enderecos)
    {
        $this->enderecos->removeElement($enderecos);
    }

    /**
     * Add contatos
     *
     * @param \Duosystem\Crud\ClienteBundle\Entity\Contato $contatos
     * @return Cliente
     */
    public function addContato(\Duosystem\Crud\ClienteBundle\Entity\Contato $contatos)
    {
        $contatos->setCliente($this);
        $this->contatos[] = $contatos;
    
        return $this;
    }

    /**
     * Remove contatos
     *
     * @param \Duosystem\Crud\ClienteBundle\Entity\Contato $contatos
     */
    public function removeContato(\Duosystem\Crud\ClienteBundle\Entity\Contato $contatos)
    {
        $this->contatos->removeElement($contatos);
    }
}