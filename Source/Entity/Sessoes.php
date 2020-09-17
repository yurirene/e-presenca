<?php


namespace Source\Entity;

use Doctrine\ORM\Mapping as ORM;



/**
 * @ORM\Entity
 * @ORM\Table(name="sessoes")
 */
class Sessoes 
{
    
    /** 
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;
    
    
    /** 
     * @ORM\Column(type="string") 
     * @var string
     */
    private $sessao;
    
    
    /**
     * @ORM\Column(type="integer", name="federacao_id") 
     * @var int
     */    
    private $federacao;
    
    
    function getId(): int
    {
        return $this->id;
    }

    function getFederacao(): int
    {
        return $this->federacao;
    }

    function getSessao(): string
    {
        return $this->sessao;
    }

    function setFederacao(int $federacao)
    {
        $this->federacao = $federacao;
    }

    function setSessao(string $sessao)
    {
        $this->sessao = $sessao;
    }


    
}
