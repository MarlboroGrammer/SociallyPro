<?php
/**
 * Created by PhpStorm.
 * User: Nizar
 * Date: 04/08/2017
 * Time: 6:29 PM
 */

namespace SocialProBundle\Repository;


class ComplaintRepository extends \Doctrine\ORM\EntityRepository
{
    public function nbrrec(){
        $query=$this->getEntityManager()
            ->createQuery("
    SELECT COUNT (c) as nb FROM SocialProBundle:Complaint c WHERE c.status='pending'");
        return $query->getSingleScalarResult();
    }
}