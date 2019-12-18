<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EmailValidationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ValidationController extends AbstractController
{
    /**
     * @Route("/validation/email", name="email_validation")
     */
    public function index(Request $request)
    {
        $form = $this->createForm(EmailValidationFormType::class, new User());

        $data = json_decode($request->getContent(), true);

        $form->handleRequest($request);
        $form->submit($data);

        if (false === $form->isValid()) {
            return new JsonResponse([
                'error' => $form->getErrors(true)->current()->getMessage(),
            ], 400);
        }

        return new JsonResponse(['success' => true], 200);
    }
}
