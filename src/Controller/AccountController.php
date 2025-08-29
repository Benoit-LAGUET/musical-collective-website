<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {
        return $this->render('account/index.html.twig', [
            'controller_name' => 'AccountController',
        ]);
    }

    #[Route('/account/password', name: 'account_change_password', methods: ['GET','POST'])]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(ChangePasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $new = $form->get('newPassword')->getData();
            $hash = $passwordHasher->hashPassword($user, $new);
            $user->setPassword($hash);
            $entityManager->flush();
            $this->addFlash('success', 'Votre mot de passe a été mis à jour.');
            return $this->redirectToRoute('account_change_password');
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

