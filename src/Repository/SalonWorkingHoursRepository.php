<?php

namespace App\Repository;

use App\Entity\SalonWorkingHours;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SalonWorkingHours>
 *
 * @method SalonWorkingHours|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalonWorkingHours|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalonWorkingHours[]    findAll()
 * @method SalonWorkingHours[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalonWorkingHoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalonWorkingHours::class);
    }

    public function save(SalonWorkingHours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SalonWorkingHours $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SalonWorkingHours[] Returns an array of SalonWorkingHours objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SalonWorkingHours
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
