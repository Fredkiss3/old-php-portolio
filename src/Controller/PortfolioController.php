<?php

namespace App\Controller;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    /**
     * @Route("/", name="portfolio.index")
     */
    public function index(EntityManagerInterface $em): Response
    {
        $project = $em->getRepository(Project::class)->findBy([], ['yearOfRealization' => 'desc']);

        return $this->render('pages/index.html.twig', [
            'projects' => $project,
        ]);
    }

    /**
     * @Route("/a-propos", name="portfolio.about")
     */
    public function about(): Response
    {
        return $this->render('pages/about.html.twig');
    }

    /**
     * @Route("/{slug<^[a-z0-9]+(?:-[a-z0-9]+)*$>}-{id<\d+>}", name="porfolio.project_detail")
     */
    public function detail(string $slug, int $id, EntityManagerInterface $em): Response
    {
        $project = $em->getRepository(Project::class)->find($id);

        if (null == $project) {
            throw $this->createNotFoundException('Ce projet n\'existe pas');
        }

        if ($slug != $project->getSlug()) {
            return $this->redirectToRoute('porfolio.project_detail', [
                'slug' => $project->getSlug(), 'id' => $project->getId(),
            ]);
        }

        return $this->render('pages/project-detail.html.twig', [
            'project' => $project,
        ]);
    }
}
