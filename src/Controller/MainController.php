<?php

declare(strict_types=1);

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class MainController
{
    /**
     * @Route("/", name="index_action")
     * @Template("index.html.twig")
     */
    public function indexAction(): array
    {
        return [];
    }

    /**
     * @Route("/login", name="login_action")
     * @Template("login.html.twig")
     */
    public function loginAction(AuthenticationUtils $utils): array
    {
        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();

        return [
            'error' => $error,
            'last_username' => $lastUsername
        ];
    }
}
