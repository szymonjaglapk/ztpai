<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\UserDetails;
use DateTime;
use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ["GET", "POST"])]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        if ($request->isMethod('POST')) {
            throw new LogicException('This should never be reached!');
        }


        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout()
    {
        throw new LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        if ($request->isMethod('POST')) {
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $name = $request->request->get('name');
            $surname = $request->request->get('surname');
            $phone = $request->request->get('phone');

            if (null === $email || null === $password || null === $name || null === $surname || null === $phone) {
                return $this->render('security/register.html.twig', ['error' => 'All fields are required.']);
            }

            $user = new User();
            $user->setEmail($email);
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $password
                )
            );

            $user->setEnabled(true);
            $user->setCreatedAt(new DateTime());
            $user->setRoles(['ROLE_USER_IN']);

            $entityManager->persist($user);

            $userDetails = new UserDetails();
            $userDetails->setUser($user);
            $userDetails->setName($name);
            $userDetails->setSurname($surname);
            $userDetails->setPhone($phone);

            $entityManager->persist($userDetails);

            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/register.html.twig');
    }
}