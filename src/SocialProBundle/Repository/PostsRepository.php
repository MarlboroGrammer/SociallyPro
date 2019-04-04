<?php
/**
 * Created by PhpStorm.
 * User: bayrem
 * Date: 09/04/2017
 * Time: 23:16
 */

namespace SocialProBundle\Repository;

use Doctrine\ORM\EntityRepository ;

class PostsRepository extends EntityRepository
{
    public function findAllDescDQL()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQuery("
                    SELECT p FROM SocialProBundle:Posts p ORDER BY p.postId DESC              
            ");
        return $queryBuilder->getResult();
    }

    public function filterSignalDQL()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQuery("
                    DELETE FROM SocialProBundle:Posts p WHERE p.postSignal > 3           
            ");
        return $queryBuilder->getResult();
    }

    public function findUsernameDQL($text)
    {
        $queryBuilder = $this->getEntityManager()
            ->createQuery("
              SELECT p FROM SocialProBundle:Posts p 
              WHERE 
              p.postSignal=:postSignal           
              ")
            ->setParameter('postSignal',$text)
        ;
        return $queryBuilder->getResult();
    }

}