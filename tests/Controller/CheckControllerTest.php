<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

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

        $client->request('GET', '/check2');
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testIndexFailOnPurpose()
    {
        $client = static::createClient();
        // toto

        $client->request('GET', '/check');
        $this->assertResponseIsUnprocessable();
    }
}