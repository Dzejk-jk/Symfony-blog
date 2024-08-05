<?php

namespace App\Tests\Entity;

use App\Entity\MicroPost;
use App\Entity\User;
use App\Entity\Comment;
use PHPUnit\Framework\TestCase;

class MicroPostTest extends TestCase
{
    public function testGetId()
    {
        $microPost = new MicroPost();
        $this->assertNull($microPost->getId());
    }

    public function testGetSetTitle()
    {
        $microPost = new MicroPost();
        $microPost->setTitle('Test Title');
        $this->assertEquals('Test Title', $microPost->getTitle());
    }

    public function testGetSetText()
    {
        $microPost = new MicroPost();
        $microPost->setText('Test Text');
        $this->assertEquals('Test Text', $microPost->getText());
    }

    public function testGetSetCreated()
    {
        $microPost = new MicroPost();
        $date = new \DateTime('2023-01-01');
        $microPost->setCreated($date);
        $this->assertEquals($date, $microPost->getCreated());
    }

    public function testGetComments()
    {
        $microPost = new MicroPost();
        $this->assertCount(0, $microPost->getComments());
    }

    public function testAddRemoveComment()
    {
        $microPost = new MicroPost();
        $comment = new Comment();

        $this->assertCount(0, $microPost->getComments());

        $microPost->addComment($comment);
        $this->assertCount(1, $microPost->getComments());
        $this->assertTrue($microPost->getComments()->contains($comment));

        $microPost->removeComment($comment);
        $this->assertCount(0, $microPost->getComments());
        $this->assertFalse($microPost->getComments()->contains($comment));
    }

    public function testGetLikedBy()
    {
        $microPost = new MicroPost();
        $this->assertCount(0, $microPost->getLikedBy());
    }

    public function testAddRemoveLikedBy()
    {
        $microPost = new MicroPost();
        $user = new User();

        $this->assertCount(0, $microPost->getLikedBy());

        $microPost->addLikedBy($user);
        $this->assertCount(1, $microPost->getLikedBy());
        $this->assertTrue($microPost->getLikedBy()->contains($user));

        $microPost->removeLikedBy($user);
        $this->assertCount(0, $microPost->getLikedBy());
        $this->assertFalse($microPost->getLikedBy()->contains($user));
    }

    public function testGetSetAuthor()
    {
        $microPost = new MicroPost();
        $user = new User();

        $microPost->setAuthor($user);
        $this->assertEquals($user, $microPost->getAuthor());
    }

    public function testIsSetExtraPrivacy()
    {
        $microPost = new MicroPost();

        $this->assertFalse($microPost->isExtraPrivacy());

        $microPost->setExtraPrivacy(true);
        $this->assertTrue($microPost->isExtraPrivacy());
    }
}
