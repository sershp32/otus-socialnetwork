<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController extends AbstractController
{
    private ProfileRepository $profile;

    public function __construct(ProfileRepository $profile)
    {
        $this->profile = $profile;
    }

    /**
     * @Route("/home", name="home_action", methods={"GET"})
     */
    public function indexAction(): Response
    {
        return $this->render('home.html.twig', [
            'profiles' => $this->profile->findAll(),
        ]);
    }
}
