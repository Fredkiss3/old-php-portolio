<?php

namespace App\Tests;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class AuthWebTest extends WebTestCase
{
    use FixturesTrait;

    const BASE_HOST = 'http://localhost';

    /**
     * @var array|User[]
     */
    protected array $entities = [];

    protected KernelBrowser $client;
    protected EntityManagerInterface $em;

    protected function setUp(): void
    {
        $this->client = static::createClient();

        if (0 == count($this->entities)) {
            // fixtures
            $this->entities = $this->loadFixtureFiles([
                __DIR__.'/fixtures/UserFixtures.yml',
            ]);
        }

        $this->em = $this->client->getContainer()->get('doctrine')->getManager();
    }

    public function testRestrictedAccess()
    {
        $this->client->request('GET', '/admin');
        $this->assertResponseRedirects(self::BASE_HOST.'/login', Response::HTTP_FOUND);
    }

    public function testLoginSuccessfull()
    {
        $this->client->request('GET', '/login');

        $user = $this->entities['user'];

        $this->client->submitForm('Se connecter', [
           '_username' => $user->getUsername(),
           '_password' => 'password',
        ]);

        $this->assertResponseRedirects(self::BASE_HOST.'/admin', Response::HTTP_FOUND);
        $this->client->request('GET', '/admin');
        $this->assertResponseIsSuccessful();
    }

    public function testShowErrorOnInvalidCredentials()
    {
        $this->client->request('GET', '/login');

        $this->client->submitForm('Se connecter', [
            '_username' => 'username',
            '_password' => 'pass',
        ]);

        $this->assertResponseRedirects( self::BASE_HOST.'/login',Response::HTTP_FOUND);
        $crawler = $this->client->followRedirect();
        $this->assertEquals(1, $crawler->filter('.alert.bg-danger')->count());
    }

    public function testLogoutSuccessfull()
    {
        $user = $this->entities['user'];
        $this->client->loginUser($user);

        $this->client->request('GET', '/logout');
        $this->assertResponseRedirects(self::BASE_HOST.'/', Response::HTTP_FOUND);

        $this->client->request('GET', '/admin');
        $this->assertResponseRedirects(self::BASE_HOST.'/login', Response::HTTP_FOUND);
    }
}
