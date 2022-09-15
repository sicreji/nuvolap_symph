<?php

namespace App\Repository;

use App\Entity\Proverb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Proverb>
 *
 * @method Proverb|null find($id, $lockMode = null, $lockVersion = null)
 * @method Proverb|null findOneBy(array $criteria, array $orderBy = null)
 * @method Proverb[]    findAll()
 * @method Proverb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProverbRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Proverb::class);
    }

    public function add(Proverb $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Proverb $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Proverb[] Returns an array of Proverb objects
    */
   public function findByLang($lang): array
   {
       return $this->createQueryBuilder('p')
           ->andWhere('p.lang = :val')
           ->setParameter('val', $lang)
           ->orderBy('p.id', 'ASC')
           ->setMaxResults(5)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findByLangDql(string $lang): array
   {
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT p FROM \App\Entity\Proverb p
                WHERE p.lang = :lang
            '
        );
        $query->setParameter('lang', $lang);
        return $query->getResult();
   }

   public function findByLangRaw(string $lang): array
   {
    $conn = $this->getEntityManager()->getConnection();

    $sql = '
        SELECT body FROM proverb p
        WHERE p.lang = :lang
        ORDER BY p.lang ASC
    ';

    $stmt = $conn->prepare($sql);
    $result = $stmt->executeQuery(['lang' => $lang]);

    return $result->fetchAllAssociative();
   }

}
