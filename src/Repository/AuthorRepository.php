<?php

namespace App\Repository;

use App\Entity\Author;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Author>
 */
class AuthorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Author::class);
    }

    public function findByDateOfBirth(array $dates = [], $returnQb = false): array|QueryBuilder
    {
        $qb = $this->createQueryBuilder('a');

        if (\array_key_exists('start', $dates)) {
            $qb->andWhere('a.dateOfBirth >= :start')
                ->setParameter('start', new \DateTimeImmutable($dates['start']));
        }

        if (\array_key_exists('end', $dates)) {
            $qb->andWhere('a.dateOfBirth <= :end')
                ->setParameter('end', new \DateTimeImmutable($dates['end']));
        }

        $qb = $qb->orderBy('a.dateOfBirth', 'DESC');
        if ($returnQb) {
            return $qb;
        }
        return $qb
            ->getQuery()
            ->getResult();
    }
}
