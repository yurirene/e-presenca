<?php


namespace Source\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table (name="usuarios")
 */

class Usuarios {
    
    
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
    private $usuario;
    
    
    /** 
     * @ORM\Column(type="string") 
     * @var string
     */
    private $senha;
    
    
    /** 
     * @ORM\Column(type="integer", name="federacao_id") 
     * @var int
     */
    private $federacao;
    
    
    
    function getId(): int {
        return $this->id;
    }

    function getUsuario(): string {
        return $this->usuario;
    }

    function getSenha(): string {
        return $this->senha;
    }

    function getFederacao(): int {
        return $this->federacao;
    }

    function setUsuario(string $nome): void {
        $this->usuario = $usuario;
    }

    function setSenha(string $senha): void {
        $this->senha = $senha;
    }

    function setFederacao(int $federacao): void {
        $this->federacao = $federacao;
    }


    
}
