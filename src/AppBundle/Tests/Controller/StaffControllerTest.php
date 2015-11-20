<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StaffControllerTest extends WebTestCase
{
    public function testAddstaff()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addStaff');
    }

    public function testUpdatestaff()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/updateStaff/{staffId}');
    }

    public function testDeletestaff()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteStaff/{staffId}');
    }

    public function testListstaff()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listStaff');
    }

}
