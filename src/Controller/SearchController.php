<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\DTO\ProfileSearchDTO;
use App\Form\ProfileSearchType;
use App\Repository\ProfileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class SearchController extends AbstractController
{
    private ValidatorInterface $validator;

    private ProfileRepository $rep;

    public function __construct(ValidatorInterface $validator, ProfileRepository $rep)
    {
        $this->validator = $validator;
        $this->rep = $rep;
    }

    /**
     * @Route("/search", name="search_action", methods={"GET", "POST"})
     */
    public function searchAction(Request $request): Response
    {
        $dto = new ProfileSearchDTO();
        $form = $this->createForm(ProfileSearchType::class, $dto);
        $form->handleRequest($request);

        $result = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $errors = $this->validator->validate($dto);

            if (0 === count($errors)) {
                $result = $this->rep->findByName($dto->firstName, $dto->lastName);
            }
        }

        return $this->render('search.html.twig', [
            'form' => $form->createView(),
            'result' => $result,
        ]);
    }
}
