<?php

namespace Source\Entity;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table (name="igrejas")
 */

class Igrejas {
    
    
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
    private $nome;
    
    /** 
     * @ORM\Column(type="integer", name="federacao_id") 
     * @var int
     */
    private $federacao;
    
    
    function getId(): int {
        return $this->id;
    }

    function getNome(): string {
        return $this->nome;
    }

    function getFederacao(): int {
        return $this->federacao;
    }

    function setNome(string $nome): void {
        $this->nome = $nome;
    }

    function setFederacao(int $federacao): void {
        $this->federacao = $federacao;
    }


    
}
