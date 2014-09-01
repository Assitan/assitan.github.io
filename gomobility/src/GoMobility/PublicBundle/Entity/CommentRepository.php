<?php

namespace GoMobility\PublicBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends EntityRepository
{
	public function getComment($id)
    {
        return $this->createQueryBuilder('a')
              ->where('a.status = :status')
              ->setParameter('status', 'publié') 
              ->andWhere('a.ecoactor = :ecoactor')
              ->setParameter('ecoactor', $id)       
              ->orderBy('a.date', 'DESC')         
              ->getQuery()
              ->getResult();
    }

  public function getPublish()
    {
        return $this->createQueryBuilder('a')
              ->where('a.status = :status')
              ->setParameter('status', 'publié')        
              ->orderBy('a.date', 'DESC')         
              ->getQuery()
              ->getResult();
    }

  public function getUnpublish()
    {
        return $this->createQueryBuilder('a')
              ->where('a.status = :status')
              ->setParameter('status', 'non publié')        
              ->orderBy('a.date', 'DESC')         
              ->getQuery()
              ->getResult();
    }

}
