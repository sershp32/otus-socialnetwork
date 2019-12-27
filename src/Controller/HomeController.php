<?php

declare(strict_types=1);

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

final class HomeController
{
    /**
     * @Route("/home", name="home_action")
     * @Template("home.html.twig")
     */
    public function indexAction(): array
    {
        return [];
    }
}
