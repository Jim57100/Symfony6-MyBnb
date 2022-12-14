<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function home(AdRepository $repo): Response
    {
        $mostRated = $repo->findMostRated();
        return $this->render('home/home.html.twig', [
            'mostRated' => $mostRated,
        ]);
    }
}
