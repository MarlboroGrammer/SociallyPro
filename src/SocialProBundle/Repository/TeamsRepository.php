<?php
/**
 * Created by PhpStorm.
 * User: LordGoats
 * Date: 4/9/2017
 * Time: 4:06 PM
 */

namespace SocialProBundle\Repository;


use Doctrine\ORM\EntityRepository;

class TeamsRepository extends EntityRepository
{
    public function findfreeTeamsQB()
    {
        $qry=$this->getEntityManager()->createQuery("select T from SocialProBundle:Teams AS T left join SocialProBundle:SubProjects AS S WITH T.teamId=S.team where S.team IS NULL ");
        return $qry->getResult();
    }
    public function findManagersQB()
    {

        $qry=$this->getEntityManager()->createQuery("select F from SocialProBundle:FosUser AS F where F.Job=2");
        return $qry->getResult();
    }
}