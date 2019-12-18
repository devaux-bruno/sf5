<?php


namespace App\Repository;


use App\Entity\Interruptions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\DBAL\DBALException;

/**
 * @method Interruptions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interruptions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interruptions[]    findAll()
 * @method Interruptions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterruptionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interruptions::class);
    }


    public function findHowManyActive()
    {
        $rawSql = "SELECT COUNT(*)
                    FROM interruptions
                    WHERE active = '1'";

        try {
            $stmt = $this->getEntityManager()->getConnection()->prepare($rawSql);
        } catch (DBALException $e) {
        }
        $stmt->execute([]);

        return $stmt->fetchAll();
    }

}