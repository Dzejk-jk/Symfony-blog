<?php

namespace App\Tests\Repository;

use App\Entity\MicroPost;
use App\Entity\User;
use App\Repository\MicroPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\Query;

class MicroPostRepositoryTest extends TestCase
{
    private $microPostRepository;
    private $entityManager;
    private $queryBuilder;
    private $query;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        $classMetadata = new ClassMetadata(MicroPost::class);
        $this->entityManager->method('getClassMetadata')
            ->willReturn($classMetadata);

        $managerRegistry = $this->createMock(ManagerRegistry::class);
        $managerRegistry->method('getManagerForClass')
            ->willReturn($this->entityManager);

        $this->microPostRepository = new MicroPostRepository($managerRegistry);

        $this->queryBuilder = $this->createMock(QueryBuilder::class);
        $this->query = $this->createMock(Query::class);

        $this->entityManager->method('createQueryBuilder')
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->method('getQuery')
            ->willReturn($this->query);
    }

    public function testAdd()
    {
        $microPost = new MicroPost();
        
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($microPost));
            
        $this->entityManager->expects($this->never())
            ->method('flush');
        
        $this->microPostRepository->add($microPost);
    }

    public function testAddWithFlush()
    {
        $microPost = new MicroPost();
        
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($microPost));
        
        $this->entityManager->expects($this->once())
            ->method('flush');
        
        $this->microPostRepository->add($microPost, true);
    }

    public function testRemove()
    {
        $microPost = new MicroPost();
        
        $this->entityManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($microPost));
            
        $this->entityManager->expects($this->never())
            ->method('flush');
        
        $this->microPostRepository->remove($microPost);
    }

    public function testRemoveWithFlush()
    {
        $microPost = new MicroPost();
        
        $this->entityManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($microPost));
        
        $this->entityManager->expects($this->once())
            ->method('flush');
        
        $this->microPostRepository->remove($microPost, true);
    }

    public function testFindAllWithComments()
    {
        $this->queryBuilder->expects($this->once())
            ->method('leftJoin')
            ->with('p.comments', 'c')
            ->willReturn($this->queryBuilder);
        
        $this->queryBuilder->expects($this->once())
            ->method('addSelect')
            ->with('c')
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($this->query);

        $this->query->expects($this->once())
            ->method('getResult')
            ->willReturn([]);
        
        $result = $this->microPostRepository->findAllWithComments();
        $this->assertIsArray($result);
    }

    public function testFindAllByAuthor()
    {
        $user = new User();

        $this->queryBuilder->expects($this->once())
            ->method('where')
            ->with('p.author = :author')
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
            ->method('setParameter')
            ->with('author', $user->getId())
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($this->query);

        $this->query->expects($this->once())
            ->method('getResult')
            ->willReturn([]);

        $result = $this->microPostRepository->findAllByAuthor($user);
        $this->assertIsArray($result);
    }

    public function testFindAllByAuthors()
    {
        $users = [new User(), new User()];

        $this->queryBuilder->expects($this->once())
            ->method('where')
            ->with('p.author IN (:authors)')
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
            ->method('setParameter')
            ->with('authors', $users)
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($this->query);

        $this->query->expects($this->once())
            ->method('getResult')
            ->willReturn([]);

        $result = $this->microPostRepository->findAllByAuthors($users);
        $this->assertIsArray($result);
    }

    public function testFindAllWithMinLikes()
    {
        $this->queryBuilder->expects($this->once())
            ->method('select')
            ->with('p.id')
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
            ->method('groupBy')
            ->with('p.id')
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
            ->method('having')
            ->with('COUNT(l) >= :minLikes')
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
            ->method('setParameter')
            ->with('minLikes', 10)
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($this->query);

        $this->query->expects($this->once())
            ->method('getResult')
            ->willReturn([]);

        $this->queryBuilder->expects($this->once())
            ->method('where')
            ->with('p.id in (:idList)')
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
            ->method('setParameter')
            ->with('idList', [])
            ->willReturn($this->queryBuilder);

        $this->queryBuilder->expects($this->once())
            ->method('getQuery')
            ->willReturn($this->query);

        $this->query->expects($this->once())
            ->method('getResult')
            ->willReturn([]);

        $result = $this->microPostRepository->findAllWithMinLikes(10);
    }
}
