<?php

declare(strict_types=1);

namespace Tests\integration;

class CandidatesTest extends TestCase
{
    private static $id;

    public function testCreate()
    {
        $params = [
            'first_name' => 'Henri',
            'last_name' => 'Jeret',
            'created_at' => time(),
            'updated_at' => time(),
        ];
        $req = $this->createRequest('POST', '/candidates');
        $request = $req->withParsedBody($params);
        $response = $this->getAppInstance()->handle($request);

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetAll()
    {
        $request = $this->createRequest('GET', '/candidates');
        $response = $this->getAppInstance()->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOne()
    {
        $request = $this->createRequest('GET', '/candidates/' . self::$id);
        $response = $this->getAppInstance()->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringContainsString('Henri', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOneNotFound()
    {
        $request = $this->createRequest('GET', '/candidates/123456789');
        $response = $this->getAppInstance()->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertStringContainsString('error', $result);
    }

    public function testUpdate()
    {
        $req = $this->createRequest('PUT', '/candidates/' . self::$id);
        $request = $req->withParsedBody(['first_name' => 'Emma', 'last_name' => 'Fields']);
        $response = $this->getAppInstance()->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('Henri', $result);
        $this->assertStringNotContainsString('Jeret', $result);
        $this->assertStringContainsString('Emma', $result);
        $this->assertStringContainsString('Fields', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testDelete()
    {
        $request = $this->createRequest('DELETE', '/candidates/' . self::$id);
        $response = $this->getAppInstance()->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertStringNotContainsString('error', $result);
    }
}
