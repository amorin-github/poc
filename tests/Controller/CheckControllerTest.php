<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CheckControllerTest extends WebTestCase
{
    public function testIndexSuccess()
    {
        $client = static::createClient();

        $client->request('GET', '/check');
        $this->assertResponseIsSuccessful();
    }

    public function testIndexFail()
    {
        $client = static::createClient();

        $client->request('GET', '/check');
        $this->assertResponseIsUnprocessable();
    }
}