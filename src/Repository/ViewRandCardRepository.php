<?php

namespace App\Repository;

use App\Entity\ViewRandCard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ViewRandCardRepository extends ServiceEntityRepository
{
    /**
     * @extends ServiceEntityRepository<ViewRandCard>
     *
     * @method ViewRandCard|null find($id, $lockMode = null, $lockVersion = null)
     * @method ViewRandCard|null findOneBy(array $criteria, array $orderBy = null)
     * @method ViewRandCard[]    findAll()
     * @method ViewRandCard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     */

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ViewRandCard::class);
    }

    public function save(ViewRandCard $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ViewRandCard $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}