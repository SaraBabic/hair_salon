<?php

namespace App\Repository;

use App\Entity\HairdresserDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HairdresserDetails>
 *
 * @method HairdresserDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method HairdresserDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method HairdresserDetails[]    findAll()
 * @method HairdresserDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HairdresserDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HairdresserDetails::class);
    }

    public function save(HairdresserDetails $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HairdresserDetails $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HairdresserDetails[] Returns an array of HairdresserDetails objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HairdresserDetails
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
