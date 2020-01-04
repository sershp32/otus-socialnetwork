<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

final class ProfileController extends AbstractController
{
    private ProfileRepository $rep;

    public function __construct(ProfileRepository $rep)
    {
        $this->rep = $rep;
    }

    /**
     * @Route("/profile/{id}", name="profile_view_action")
     */
    public function viewAction($id): Response
    {
        $profile = $this->rep->find((int)$id);

        if (null === $profile) {
            throw new NotFoundHttpException('User is not found');
        }

        return $this->render('profile.html.twig', [
            'profile' => $profile,
        ]);
    }
}
