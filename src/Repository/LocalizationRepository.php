<?php

namespace App\Repository;

use App\Entity\City;
use App\Entity\Localization;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Mysql\Radians;

/**
 * @extends ServiceEntityRepository<Localization>
 *
 * @method Localization|null find($id, $lockMode = null, $lockVersion = null)
 * @method Localization|null findOneBy(array $criteria, array $orderBy = null)
 * @method Localization[]    findAll()
 * @method Localization[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LocalizationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Localization::class);
    }

    public function save(Localization $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Localization $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Localization[] Returns an array of Localization objects
     */
    public function findGardeners(City $value): array
    {

        $lat = $value->getLatitude();
        $lon = $value->getLongitude();

        $queryBuilder = $this->createQueryBuilder('l')
                                ->join('l.city', 'c')
                                ->andWhere('((2 * ATAN2(SQRT(POWER(SIN(RADIANS(c.latitude - :lat) / 2.0), 2) + COS(RADIANS(:lat)) * COS(RADIANS(c.latitude)) * POWER(SIN(RADIANS(c.longitude - :lon) / 2.0), 2)), SQRT(1 - POWER(SIN(RADIANS(c.latitude - :lat) / 2.0), 2) + COS(RADIANS(:lat)) * COS(RADIANS(c.latitude)) * POWER(SIN(RADIANS(c.longitude - :lon) / 2.0), 2)))) * :r /1000) <= l.radius')
                                ->setParameter('r', 6371000)
                                ->setParameter('lat', $lat)
                                ->setParameter('lon', $lon);
        $query = $queryBuilder->getQuery();
        
        return  $query->getResult();


        
    }



    // REQUETE SQL SELECT *, ((2 * atan2(sqrt(POW(sin(radians(c.latitude - 43.935441391) / 2.0), 2) + cos(radians(43.935441391)) * cos(radians(c.latitude)) * POW(sin(radians(c.longitude - 4.841098248) / 2.0), 2)), sqrt(1 - POW(sin(radians(c.latitude - 43.935441391) / 2.0), 2) + cos(radians(43.935441391)) * cos(radians(c.latitude)) * POW(sin(radians(c.longitude - 4.841098248) / 2.0), 2)))) * 6371000 /1000) FROM localization l INNER JOIN city c ON l.city_id = c.id


    public function afficherCoordonnees(City $value)
    {

        $lat = $value->getLatitude();
        $lon = $value->getLongitude();

        dd($lat, $lon);
    }

    //    public function findOneBySomeField($value): ?Localization
    //    {
    //        return $this->createQueryBuilder('l')
    //            ->andWhere('l.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
