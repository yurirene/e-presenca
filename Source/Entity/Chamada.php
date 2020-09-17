<?php


namespace Source\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table (name="chamada")
 */

class Chamada 
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    private $id;
    
    /** 
     * @ORM\Column(type="integer", name="federacao_id") 
     * @var int
     */
    private $federacao;
    
    /** 
     * @ORM\Column(type="integer", name="sessao_id") 
     * @var int
     */
    private $sessao;
    
    
    /** 
     * @ORM\Column(type="integer", name="delegado_id") 
     * @var int
     */
    private $delegado;
    
    
    
    function getId() {
        return $this->id;
    }

    function getFederacao() {
        return $this->federacao;
    }

    function getSessao() {
        return $this->sessao;
    }

    function getDelegado() {
        return $this->delegado;
    }

    function setFederacao($federacao): void {
        $this->federacao = $federacao;
    }

    function setSessao($sessao): void {
        $this->sessao = $sessao;
    }

    function setDelegado($delegado): void {
        $this->delegado = $delegado;
    }


    
    
}
