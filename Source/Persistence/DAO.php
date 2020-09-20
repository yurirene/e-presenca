<?php

namespace Source\Persistence;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

abstract class DAO
{
    
    private $entityManager;
    private $entityPath;
    private $conection;
    
    public function __construct($path) {
        $this->entityPath = $path;
        $this->entityManager = $this->createEntityManager();
    }
    
    public function createEntityManager()
    {
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/Source/Entity"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
        $conn = DriverManager::getConnection(ORM_CONFIG);
        $this->conection = $conn;
        $entityManager = EntityManager::create($conn, $config);
        
        return $entityManager;        
    }
    
    public function getEntityManager()
    {
        return $this->entityManager;
        
    }
    public function getConection() 
    {
        return $this->conection;
        
    }
    
    public function insert($data)
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
    
    public function update($data)
    {
        $this->entityManager->merge($data);
        $this->entityManager->flush();
        
    }
    
    public function delete($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();        
    }
    
    public function findById($id)
    {
        return $this->entityManager->find($this->entityPath, $id);
    }
    
    public function findAll()
    {
        $collection = $this->entityManager->getRepository($this->entityPath)->findAll();
        $data = array();
        
        foreach($collection as $obj){
            $data[]=$obj;
        }
        
        return $data;
    }
    
    public function findOneBy(array $param, ?array $order = null) 
    {
        return $this->entityManager->getRepository($this->entityPath)->findOneBy($param, $order);
        
    }
    
    
    public function findBy(array $param, ?array $order = null) 
    {
        return $this->entityManager->getRepository($this->entityPath)->findBy($param, $order);
        
    }
    
    
}
