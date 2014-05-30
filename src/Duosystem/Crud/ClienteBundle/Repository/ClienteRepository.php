<?php

namespace Duosystem\Crud\ClienteBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ClienteRepository extends EntityRepository {

    public function findNomeLike($filtro){

        $select = $this->createQueryBuilder('c');
        $sqlNome = $select->expr()->like("c.nome", $select->expr()->literal("%{$filtro}%"));
        $select->where($sqlNome);

        $result = $select->getQuery()->getResult();

        return $result;
    }

}

