<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\DTO\RegisterUserDTO;
use App\Form\RegisterUserType;
use App\Manager\UserManager;
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

    private UserManager $manager;

    public function __construct(
        AuthorizationCheckerInterface $authChecker,
        ValidatorInterface $validator,
        UserManager $manager
    )
    {
        $this->authChecker = $authChecker;
        $this->validator = $validator;
        $this->manager = $manager;
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
        $error = null;

        $form = $this->createForm(RegisterUserType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $this->validator->validate($dto);

            if (0 === count($errors)) {
                try {
                    $this->manager->createFromDTO($dto);
                    return $this->redirectToRoute('login_action');
                } catch (\Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        return $this->render('register.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }
}
