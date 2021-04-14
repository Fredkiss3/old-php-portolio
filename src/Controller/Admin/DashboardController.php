<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Entity\Technology;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $env = $this->kernel->getEnvironment();

        if ('test' == $env) {
            return parent::index();
        } else {
            $routeBuilder = $this->get(CrudUrlGenerator::class)->build();

            return $this->redirect($routeBuilder->setController(ProjectCrudController::class)->generateUrl());
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Portolio');
    }

    public function configureMenuItems(): iterable
    {
         yield MenuItem::linkToCrud('Projets', 'fas fa-list', Project::class);
         yield MenuItem::linkToCrud('Technologies', 'fas fa-microchip', Technology::class);
    }
}
