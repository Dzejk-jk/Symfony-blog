<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\MicroPost;
use App\Entity\Comment;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testGetId()
    {
        $user = new User();
        $this->assertNull($user->getId());
    }

    public function testGetSetEmail()
    {
        $user = new User();
        $user->setEmail('test@example.com');
        $this->assertEquals('test@example.com', $user->getEmail());
    }

    public function testGetSetPassword()
    {
        $user = new User();
        $user->setPassword('password');
        $this->assertEquals('password', $user->getPassword());
    }

    public function testGetRoles()
    {
        $user = new User();
        $this->assertEquals(['ROLE_USER'], $user->getRoles());

        $user->setRoles(['ROLE_ADMIN']);
        $this->assertEquals(['ROLE_ADMIN', 'ROLE_USER'], $user->getRoles());
    }

    public function testGetSetIsVerified()
    {
        $user = new User();
        $this->assertFalse($user->isVerified());

        $user->setVerified(true);
        $this->assertTrue($user->isVerified());
    }

    public function testAddRemoveLiked()
    {
        $user = new User();
        $post = new MicroPost();

        $this->assertCount(0, $user->getLiked());

        $user->addLiked($post);
        $this->assertCount(1, $user->getLiked());
        $this->assertTrue($user->getLiked()->contains($post));

        $user->removeLiked($post);
        $this->assertCount(0, $user->getLiked());
        $this->assertFalse($user->getLiked()->contains($post));
    }

    public function testFollowUnfollow()
    {
        $user = new User();
        $follower = new User();

        $this->assertCount(0, $user->getFollows());
        $this->assertCount(0, $follower->getFollowers());

        $user->follow($follower);
        $this->assertCount(1, $user->getFollows());
        $this->assertCount(1, $follower->getFollowers());
        $this->assertTrue($user->getFollows()->contains($follower));
        $this->assertTrue($follower->getFollowers()->contains($user));

        $user->unfollow($follower);
        $this->assertCount(0, $user->getFollows());
        $this->assertCount(0, $follower->getFollowers());
        $this->assertFalse($user->getFollows()->contains($follower));
        $this->assertFalse($follower->getFollowers()->contains($user));
    }

    public function testGetUserIdentifier()
    {
        $user = new User();
        $user->setEmail('identifier@example.com');
        $this->assertEquals('identifier@example.com', $user->getUserIdentifier());
    }

    public function testEraseCredentials()
    {
        $user = new User();
        $user->eraseCredentials();
        $this->assertTrue(true); // Simple test to ensure the method runs without errors
    }

    public function testAddRemovePost()
    {
        $user = new User();
        $post = new MicroPost();

        $this->assertCount(0, $user->getPosts());

        $user->addPost($post);
        $this->assertCount(1, $user->getPosts());
        $this->assertTrue($user->getPosts()->contains($post));

        $user->removePost($post);
        $this->assertCount(0, $user->getPosts());
        $this->assertFalse($user->getPosts()->contains($post));
    }

    public function testAddRemoveComment()
    {
        $user = new User();
        $comment = new Comment();

        $this->assertCount(0, $user->getComments());

        $user->addComment($comment);
        $this->assertCount(1, $user->getComments());
        $this->assertTrue($user->getComments()->contains($comment));

        $user->removeComment($comment);
        $this->assertCount(0, $user->getComments());
        $this->assertFalse($user->getComments()->contains($comment));
    }

    public function testGetSetImage()
    {
        $user = new User();
        $user->setImage('image.jpg');
        $this->assertEquals('image.jpg', $user->getImage());
    }
}
