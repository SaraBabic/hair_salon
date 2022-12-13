<?php

namespace App\Repository;

use App\Entity\Salon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Salon>
 *
 * @method Salon|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salon|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salon[]    findAll()
 * @method Salon[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salon::class);
    }

    public function save(Salon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Salon $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function findFiveBestRatedSalons()
    {
        $sql = " SELECT s.id, s.name, s.imagePath, (SELECT AVG(sr.rate) FROM App\Entity\SalonRating sr WHERE sr.salon = s.id ) AS rate 
                    FROM App\Entity\Salon s ORDER BY rate DESC";

        return $this->getEntityManager()->createQuery($sql)->setMaxResults(5)->getResult();
    }

    public function findAllSalonCities()
    {
        return $this->createQueryBuilder('s')
            ->select('s.city')
            ->groupBy('s.city')
            ->getQuery()
            ->getResult()
        ;
    }
}
