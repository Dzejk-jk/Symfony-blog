<?php

namespace App\Tests\Entity;

use App\Entity\Comment;
use App\Entity\MicroPost;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    public function testGetId()
    {
        $comment = new Comment();
        $this->assertNull($comment->getId());
    }

    public function testGetSetText()
    {
        $comment = new Comment();
        $comment->setText('This is a test comment');
        $this->assertEquals('This is a test comment', $comment->getText());
    }

    public function testGetSetPost()
    {
        $comment = new Comment();
        $microPost = new MicroPost();
        
        $comment->setPost($microPost);
        $this->assertEquals($microPost, $comment->getPost());
    }

    public function testGetSetAuthor()
    {
        $comment = new Comment();
        $user = new User();

        $comment->setAuthor($user);
        $this->assertEquals($user, $comment->getAuthor());
    }

    public function testGetSetCreated()
    {
        $comment = new Comment();
        $date = new \DateTime('2023-01-01');
        $comment->setCreated($date);
        $this->assertEquals($date, $comment->getCreated());
    }
}
