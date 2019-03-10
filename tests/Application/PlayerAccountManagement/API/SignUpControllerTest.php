<?php
declare(strict_types=1);

namespace App\Tests\Application\PlayerAccountManagement\API;

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
        $client->request(Request::METHOD_POST, '/players', [
            'email' => 'john.snow@winterfell.north',
            'password' => 'winterIsComing',
            'name' => 'White Wolf',
        ]);

        $this->assertSame(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
        $response = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(isset($response['player']['id']));
        $this->assertSame(36, strlen($response['player']['id']));
        $this->assertSame($response['player']['email'], 'john.snow@winterfell.north');
        $this->assertSame($response['player']['name'], 'White Wolf');
        $this->assertTrue(isset($response['player']['token']));
    }
}
