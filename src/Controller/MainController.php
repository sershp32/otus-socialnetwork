<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\DTO\RegisterUserDTO;
use App\Form\RegisterUserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class MainController extends AbstractController
{
    private AuthorizationCheckerInterface $authChecker;

    private ValidatorInterface $validator;

    public function __construct(
        AuthorizationCheckerInterface $authChecker,
        ValidatorInterface $validator
    )
    {
        $this->authChecker = $authChecker;
        $this->validator = $validator;
    }

    /**
     * @Route("/", name="index_action")
     */
    public function indexAction(): Response
    {
        return $this->render('index.html.twig', []);
    }

    /**
     * @Route("/login", name="login_action")
     */
    public function loginAction(AuthenticationUtils $utils): Response
    {
        $error = $utils->getLastAuthenticationError();

        return $this->render('login.html.twig', [
            'error' => $error,
            'last_username' => '',
        ]);
    }

    /**
     * @Route("/register", name="register_action")
     */
    public function registerAction(Request $request): Response
    {
        $dto = new RegisterUserDTO();

        $form = $this->createForm(RegisterUserType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $this->validator->validate($dto);
            dump($errors);
        }

        return $this->render('register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
