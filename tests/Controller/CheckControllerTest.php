<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CheckControllerTest extends WebTestCase
{
    public function testIndexSuccess(): void
    {
        $client = static::createClient();

        $client->request('GET', '/check');
        $this->assertResponseIsSuccessful();
    }

    public function testIndexFail(): void
    {
        $client = static::createClient();

        $client->request('GET', '/check2');
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
