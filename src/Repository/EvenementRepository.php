<?php

namespace App\Repository;

use App\Entity\Evenement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evenement>
 *
 * @method Evenement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evenement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evenement[]    findAll()
 * @method Evenement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvenementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evenement::class);
    }
    // Count of events by type
    public function countEventsByType(): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.typeEvenement, COUNT(e.id) as count') // Use correct method chain
            ->groupBy('e.typeEvenement') // Ensure correct method chaining
            ->getQuery() // Finalize query
            ->getResult(); // Execute and return result
    }
    // Count of confirmed events
    public function countTotalEvents(): int
    {
        return $this->createQueryBuilder('e')
            ->select('COUNT(e.id)')  // Correct syntax
            ->getQuery()            // Get the query
            ->getSingleScalarResult();  // Get a single scalar result
    }

    // Count of not confirmed events
    public function countNotConfirmedEvents(): int
    {
        return $this->createQueryBuilder('e')
                ->select('COUNT(e.id)') // Call 'select' before 'where'
            ->where('e.status = :status') // Apply the 'where' condition
            ->setParameter('status', false) // Set the parameter for 'status'
                ->getQuery() // Get the query
            ->getSingleScalarResult(); // Retrieve the scalar result
    }


    // Total number of events
    public function countConfirmedEvents(): int
    {
        return $this->createQueryBuilder('e')
                ->select('COUNT(e.id)') // Call 'select' before 'where'
            ->where('e.status = :status') // Apply the 'where' condition
            ->setParameter('status', 1) // Set the parameter for 'status'
                ->getQuery() // Get the query
            ->getSingleScalarResult(); // Retrieve the scalar result
    }

    // Find upcoming events
    public function findUpcomingEvents(): array
    {
        return $this->createQueryBuilder('e')
                ->where('e.timeEventDebut > :now')
                ->setParameter('now', new \DateTime())
                ->orderBy('e.timeEventDebut', 'ASC')
                ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Evenement[] Returns an array of Evenement objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evenement
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
