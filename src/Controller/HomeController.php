<?php

declare(strict_types=1);

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home_action")
     */
    public function indexAction(): Response
    {
        return $this->render('home.html.twig', []);
    }
}
