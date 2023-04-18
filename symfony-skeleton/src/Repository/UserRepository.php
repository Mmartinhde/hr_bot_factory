<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineExtensions\Query\Mysql\DateFormat;


/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(User $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(User $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function findByClient($value)
    {
//         $query = $repository->createQueryBuilder('u')
//     ->innerJoin('p.client', 'c')
//     ->where('p.client = c.id')
//     ->getQuery();

        // $users = $query->getResult();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


   public function getUsersByFilter($userSearch = null)
   {
        $query = $this->createQueryBuilder('u')
                //->innerJoin('u.client', 'c')
                //->where('u.client = c.id')
                ->where('u.name LIKE :userSearch')
                ->orWhere('u.lastName LIKE :userSearch')
                ->orWhere('u.town LIKE :userSearch')
                ->orWhere('u.category LIKE :userSearch')
                ->orWhere('u.age LIKE :userSearch')
                ->orWhere("DATE_FORMAT(u.dateCreation, '%d/%m/%Y') LIKE :userSearch")
                ->orWhere("DATE_FORMAT(u.dateUpdate, '%d/%m/%Y') LIKE :userSearch")
                ->setParameter('userSearch', '%'.$userSearch.'%');

                if ($userSearch && $userSearch == 'No') {
                   $query->andWhere('u.active = false');
                } else if ($userSearch && $userSearch == 'Sí') {
                   $query->andWhere('u.active = true');
                }
       // dump($qb);exit();

        return $query->getQuery()->getResult();

    }

}
