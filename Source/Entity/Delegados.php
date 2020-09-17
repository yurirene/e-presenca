<?php

namespace Source\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table (name="delegados")
 */
class Delegados 
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
    private $nome;
    
    
    /** 
     * @ORM\Column(type="string") 
     * @var string
     */
    private $igreja;
    
    /** 
     * @ORM\Column(type="string") 
     * @var string
     */
    private $codigo;
        
    /** 
     * @ORM\Column(type="integer", name="federacao_id") 
     * @var int
     */
    private $federacao;
    
    
    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getIgreja() {
        return $this->igreja;
    }

    function getFederacao() {
        return $this->federacao;
    }

    function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }

    function setIgreja($igreja) {
        $this->igreja = $igreja;
        return $this;
    }

    function setFederacao($federacao) {
        $this->federacao = $federacao;
        return $this;
    }

    function getCodigo(): string {
        return $this->codigo;
    }

    function setCodigo(string $codigo) {
        $this->codigo = $codigo;
        return $this;
    }

    

    
}
