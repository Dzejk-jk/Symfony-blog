<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\UserProfile;
use PHPUnit\Framework\TestCase;

class UserProfileTest extends TestCase
{
    public function testGetId()
    {
        $userProfile = new UserProfile();
        $this->assertNull($userProfile->getId());
    }

    public function testGetSetName()
    {
        $userProfile = new UserProfile();
        $userProfile->setName('John Doe');
        $this->assertEquals('John Doe', $userProfile->getName());
    }

    public function testGetSetBio()
    {
        $userProfile = new UserProfile();
        $userProfile->setBio('This is a bio.');
        $this->assertEquals('This is a bio.', $userProfile->getBio());
    }

    public function testGetSetWebsiteUrl()
    {
        $userProfile = new UserProfile();
        $userProfile->setWebsiteUrl('https://example.com');
        $this->assertEquals('https://example.com', $userProfile->getWebsiteUrl());
    }

    public function testGetSetTwitterUsername()
    {
        $userProfile = new UserProfile();
        $userProfile->setTwitterUsername('@johndoe');
        $this->assertEquals('@johndoe', $userProfile->getTwitterUsername());
    }

    public function testGetSetCompany()
    {
        $userProfile = new UserProfile();
        $userProfile->setCompany('Example Inc.');
        $this->assertEquals('Example Inc.', $userProfile->getCompany());
    }

    public function testGetSetLocation()
    {
        $userProfile = new UserProfile();
        $userProfile->setLocation('New York');
        $this->assertEquals('New York', $userProfile->getLocation());
    }

    public function testGetSetDateOfBirth()
    {
        $userProfile = new UserProfile();
        $date = new \DateTime('2000-01-01');
        $userProfile->setDateOfBirth($date);
        $this->assertEquals($date, $userProfile->getDateOfBirth());
    }

    public function testGetSetUser()
    {
        $userProfile = new UserProfile();
        $user = new User();
        $userProfile->setUser($user);
        $this->assertEquals($user, $userProfile->getUser());
    }

    public function testGetSetImage()
    {
        $userProfile = new UserProfile();
        $userProfile->setImage('image.jpg');
        $this->assertEquals('image.jpg', $userProfile->getImage());
    }
}
