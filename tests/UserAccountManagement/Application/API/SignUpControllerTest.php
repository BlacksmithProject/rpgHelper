<?php
declare(strict_types=1);

namespace App\Tests\UserAccountManagement\Application\API;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Process\Process;

final class SignUpControllerTest extends WebTestCase
{
    protected function setUp()
    {
        $systemCommand = sprintf("make database");

        $process = Process::fromShellCommandline($systemCommand);
        $process->run();

        return $process->getOutput();
    }

    public function testSignUp(): void
    {
        $client = static::createClient();
        $client->request(Request::METHOD_POST, '/users', [
            'email' => 'john.snow@winterfell.north',
            'password' => 'winterIsComing',
            'name' => 'White Wolf',
        ]);

        $this->assertSame(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(isset($response['user']['id']));
        $this->assertSame(36, strlen($response['user']['id']));
        $this->assertSame($response['user']['email'], 'john.snow@winterfell.north');
        $this->assertSame($response['user']['name'], 'White Wolf');
        $this->assertTrue(isset($response['user']['token']));
    }
}
