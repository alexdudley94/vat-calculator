<?php

namespace App\Repository;

use App\Entity\CalculationResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CalculationResult>
 *
 * @method CalculationResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method CalculationResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method CalculationResult[]    findAll()
 * @method CalculationResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CalculationResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CalculationResult::class);
    }

    public function add(CalculationResult $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(CalculationResult $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
