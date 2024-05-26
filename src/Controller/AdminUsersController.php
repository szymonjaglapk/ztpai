<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Doctor;
use App\Entity\Appointment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AdminUsersController extends AbstractController
{
    #[Route('/admin_users', name: 'app_admin_users')]
    public function index(): Response
    {
        return $this->render('admin_users/index.html.twig', [
            'controller_name' => 'AdminUsersController',
        ]);
    }
    #[Route('/api/admin_users', name: 'api_admin_users', methods: ['GET'])]
    public function getUsers(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(User::class);
        $users = $repository->findAll();
        $usersArray = [];

        foreach ($users as $user) {
            $userDetails = $user->getUserDetails();

            $usersArray[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'name' => $userDetails->getName(),
                'surname' => $userDetails->getSurname(),
            ];
        }

        return $this->json($usersArray);
    }
    #[Route('/api/deleteUser/{id}', name: 'api_deleteUser', methods: ['POST'])]
    public function deleteUser($id, EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(User::class);
        $user = $repository->find($id);

        if ($user) {

            $doctorRepository = $em->getRepository(Doctor::class);
            $appointmentRepository = $em->getRepository(Appointment::class);
            $doctor = $doctorRepository->findOneBy(['user' => $user]);

            if ($doctor) {
                $appointments = $appointmentRepository->findBy(['doctor' => $doctor]);

                foreach ($appointments as $appointment) {
                    $em->remove($appointment);
                }

                $em->remove($doctor);
            } else {
                $appointments = $appointmentRepository->findBy(['user' => $user]);

                foreach ($appointments as $appointment) {
                    $appointment->setUser(null);
                    $appointment->setStatus('available');
                }
            }

            $em->remove($user);
            $em->flush();

            return $this->json(['message' => 'User and associated appointments deleted or updated successfully']);
        }

        return $this->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
    }
}
