<?php
namespace App\Tests\Repository;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Mapping\ClassMetadata;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

class UserRepositoryTest extends TestCase
{
    private $userRepository;
    private $entityManager;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);

        $classMetadata = new ClassMetadata(User::class);
        $this->entityManager->method('getClassMetadata')
            ->willReturn($classMetadata);

        $managerRegistry = $this->createMock(ManagerRegistry::class);
        $managerRegistry->method('getManagerForClass')
            ->willReturn($this->entityManager);

        $this->userRepository = new UserRepository($managerRegistry);
    }

    public function testAdd()
    {
        $user = new User();
        
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($user));
            
        $this->entityManager->expects($this->never())
            ->method('flush');
        
        $this->userRepository->add($user);
    }

    public function testAddWithFlush()
    {
        $user = new User();
        
        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($user));
        
        $this->entityManager->expects($this->once())
            ->method('flush');
        
        $this->userRepository->add($user, true);
    }

    public function testRemove()
    {
        $user = new User();
        
        $this->entityManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($user));
            
        $this->entityManager->expects($this->never())
            ->method('flush');
        
        $this->userRepository->remove($user);
    }

    public function testRemoveWithFlush()
    {
        $user = new User();
        
        $this->entityManager->expects($this->once())
            ->method('remove')
            ->with($this->equalTo($user));
        
        $this->entityManager->expects($this->once())
            ->method('flush');
        
        $this->userRepository->remove($user, true);
    }

    public function testUpgradePassword()
    {
        $user = new User();
        $newHashedPassword = 'new_hashed_password';

        $this->entityManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($user));
        
        $this->entityManager->expects($this->once())
            ->method('flush');
        
        $this->userRepository->upgradePassword($user, $newHashedPassword);
        
        $this->assertEquals($newHashedPassword, $user->getPassword());
    }

    public function testUpgradePasswordWithUnsupportedUser()
    {
        $this->expectException(UnsupportedUserException::class);
        
        $unsupportedUser = $this->createMock(PasswordAuthenticatedUserInterface::class);
        
        $this->userRepository->upgradePassword($unsupportedUser, 'new_hashed_password');
    }
}
