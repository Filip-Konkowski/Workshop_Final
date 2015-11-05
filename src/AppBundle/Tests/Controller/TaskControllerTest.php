<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testViewtasklist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/viewTaskList');
    }

    public function testAddtask()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addTask');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/delete');
    }

    public function testEdittask()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editTask');
    }

}
