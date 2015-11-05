<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CategoryControllerTest extends WebTestCase
{
    public function testViewcategorieslist()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/viewCategoriesList');
    }

    public function testAddcategory()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addCategory');
    }

    public function testAddformcategory()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addFormCategory');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/delete');
    }

    public function testEditcategory()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/editCategory');
    }

}
