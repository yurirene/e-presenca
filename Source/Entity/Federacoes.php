<?php


namespace Source\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(name="federacoes")
 */
class Federacoes 
{
    /** 
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var int
     */
    private $id;
    
    /** 
     * @ORM\Column(type="string") 
     * @var string
     */
    private $sigla;
    
    function getSigla(): string
    {
        return $this->sigla;
    }

    function setSigla(string $sigla): void 
    {
        $this->sigla = $sigla;
    }

    function getId(): int
    {
        return $this->id;
    }
    
    
}
