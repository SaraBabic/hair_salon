<?php

namespace App\Repository;

use App\Entity\SalonRating;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SalonRating>
 *
 * @method SalonRating|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalonRating|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalonRating[]    findAll()
 * @method SalonRating[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalonRatingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SalonRating::class);
    }

    public function save(SalonRating $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SalonRating $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAverageRatingForSalon($salonID)
    {
        return $this->createQueryBuilder('s')
            ->select('AVG(s.rate) as avg_rate')
            ->andWhere('s.salon = :val')
            ->setParameter('val', $salonID)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?SalonRating
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
