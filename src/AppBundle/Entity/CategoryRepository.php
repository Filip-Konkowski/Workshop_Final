<?php

namespace AppBundle\Entity;

/**
 * CategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategoryRepository extends \Doctrine\ORM\EntityRepository
{
    public function findByUser($user) {
        return $this->findBy(array("user" => $user), array("name" => "desc"));
    }

}
