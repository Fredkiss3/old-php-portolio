<?php

namespace App\Tests;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PortfolioWebTest extends WebTestCase
{
    use FixturesTrait;
    const BASE_HOST = 'http://localhost';

    /**
     * @var array|Project[]
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
                __DIR__.'/fixtures/ProjectFixtures.yml',
            ]);
        }

        $this->em = $this->client->getContainer()->get('doctrine')->getManager();
    }

    public function testHomePage()
    {
        $crawler = $this->client->request('GET', '/');
        $this->assertResponseIsSuccessful();

        $projects = $this->em->getRepository(Project::class)->findAll();

        $this->assertEquals(count($projects), $crawler->filter('h2')->count());
    }

    public function testProjectDetailSuccessfull()
    {
        $project = $this->entities['project.client1'];

        $this->client->request('GET', '/'.$project->getSlug().'-'.$project->getId());
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', $project->getTitle());
    }

    public function testRedirectToCorrectSlugIfBadSlug()
    {
        $project = $this->entities['project.stage1'];

        $this->client->request('GET', '/azeaze-'.$project->getId());
        $this->assertResponseRedirects(
            '/'.$project->getSlug().'-'.$project->getId(),
            Response::HTTP_FOUND
        );
    }

    public function testShow404IfProjectNotFound()
    {
        $this->client->request('GET', '/azeaze-45487');
        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }

    public function testAboutPage()
    {
        $this->client->request('GET', '/a-propos');
        $this->assertResponseIsSuccessful();

        $this->assertSelectorTextContains('h1', 'A propos');
    }
}
