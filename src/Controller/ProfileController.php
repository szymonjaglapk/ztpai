<?php

namespace App\Controller;

use App\Entity\Appointment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        $user = $this->getUser();

        return $this->render('profile/index.html.twig', [
            'user' => $user
        ]);
    }
    #[Route('/api/myId', name: 'api_myId')]
    public function apiUser(): Response
    {
        $user = $this->getUser();
        $userDetails = $user->getUserDetails();

        return $this->json([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'name' => $userDetails->getName(),
            'surname' => $userDetails->getSurname(),
            'phone' => $userDetails->getPhone(),
        ]);
    }

    #[Route('/api/myAppointments', name: 'api_myAppointments')]
    public function apiUserAppointments(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $repository = $em->getRepository(Appointment::class);

        $query = $repository->createQueryBuilder('a')
            ->where('a.user = :user')
            ->andWhere('a.date >= :today')
            ->setParameter('user', $user)
            ->setParameter('today', new \DateTime())
            ->getQuery();

        $appointments = $query->getResult();

        $appointmentsArray = [];
        foreach ($appointments as $appointment) {
            $doctor = $appointment->getDoctor();
            $doctorUser = $doctor->getUser();
            $doctorUserDetails = $doctorUser->getUserDetails();

            $appointmentsArray[] = [
                'id' => $appointment->getId(),
                'date' => $appointment->getDate()->format('Y-m-d H:i:s'),
                'status' => $appointment->getStatus(),
                'doctor' => [
                    'id' => $doctor->getId(),
                    'email' => $doctorUser->getEmail(),
                    'name' => $doctorUserDetails->getName(),
                    'surname' => $doctorUserDetails->getSurname(),
                    'phone' => $doctorUserDetails->getPhone(),
                ],
            ];
        }

        return $this->json($appointmentsArray);
    }
    #[Route('/api/cancelAppointment/{id}', name: 'api_cancelAppointment', methods: ['POST'])]
    public function apiCancelAppointment($id, EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Appointment::class);
        $appointment = $repository->find($id);

        if ($appointment && $appointment->getUser() === $this->getUser()) {
            $appointment->setUser(null);
            $appointment->setStatus('available');

            $em->persist($appointment);
            $em->flush();

            return $this->json(['message' => 'Appointment.jsx cancelled successfully']);
        }

        return $this->json(['message' => 'Appointment.jsx not found or not owned by the user'], Response::HTTP_NOT_FOUND);
    }
    #[Route('/api/myPastAppointments', name: 'api_myPastAppointments')]
    public function apiUserPastAppointments(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $repository = $em->getRepository(Appointment::class);

        $query = $repository->createQueryBuilder('a')
            ->where('a.user = :user')
            ->andWhere('a.date < :today')
            ->setParameter('user', $user)
            ->setParameter('today', new \DateTime())
            ->getQuery();

        $appointments = $query->getResult();

        $appointmentsArray = [];
        foreach ($appointments as $appointment) {
            $doctor = $appointment->getDoctor();
            $doctorUser = $doctor->getUser();
            $doctorUserDetails = $doctorUser->getUserDetails();

            $appointmentsArray[] = [
                'id' => $appointment->getId(),
                'date' => $appointment->getDate()->format('Y-m-d H:i:s'),
                'status' => $appointment->getStatus(),
                'doctor' => [
                    'id' => $doctor->getId(),
                    'email' => $doctorUser->getEmail(),
                    'name' => $doctorUserDetails->getName(),
                    'surname' => $doctorUserDetails->getSurname(),
                    'phone' => $doctorUserDetails->getPhone(),
                ],
            ];
        }

        return $this->json($appointmentsArray);
    }
}
