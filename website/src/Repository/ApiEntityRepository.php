<?php

namespace App\Repository;

use App\Entity\ApiEntity;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

//require_once (__DIR__ . '/key.php');
//require_once(__DIR__ . '/../vendor/autoload.php');

/**
 * @extends ServiceEntityRepository<ApiEntity>
 *
 * @method ApiEntity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiEntity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiEntity[]    findAll()
 * @method ApiEntity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiEntityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiEntity::class);
    }

    public function add(ApiEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ApiEntity $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ApiEntity[] Returns an array of ApiEntity objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ApiEntity
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
