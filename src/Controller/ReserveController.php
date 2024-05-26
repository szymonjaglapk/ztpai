<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\Doctor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ReserveController extends AbstractController
{
    #[Route('/reserve', name: 'app_reserve')]
    public function index(): Response
    {
        return $this->render('reserve/index.html.twig', [
            'controller_name' => 'ReserveController',
        ]);
    }
    #[Route('/api/reserveAppointment/{id}', name: 'api_reserveAppointment', methods: ['POST'])]
    public function apiReserveAppointment($id, EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Appointment::class);
        $appointment = $repository->find($id);

        if ($appointment && $appointment->getStatus() === 'available') {
            $appointment->setUser($this->getUser());
            $appointment->setStatus('reserved');

            $em->persist($appointment);
            $em->flush();

            return $this->json(['message' => 'Appointment reserved successfully']);
        }

        return $this->json(['message' => 'Appointment not found or not available'], Response::HTTP_NOT_FOUND);
    }

    #[Route('/api/searchAppointments/{dateFrom}/{dateTo}/{doctorId?}', name: 'api_searchAppointments')]
    public function apiSearchAppointments($dateFrom, $dateTo, EntityManagerInterface $em, $doctorId = null): Response
    {
        $repository = $em->getRepository(Appointment::class);

        $queryBuilder = $repository->createQueryBuilder('a')
            ->where('a.date >= :dateFrom')
            ->andWhere('a.date <= :dateTo')
            ->andWhere('a.status = :status')
            ->setParameter('dateFrom', new \DateTime($dateFrom))
            ->setParameter('dateTo', new \DateTime($dateTo))
            ->setParameter('status', 'available');

        if ($doctorId !== null) {
            $queryBuilder->andWhere('a.doctor = :doctorId')
            ->setParameter('doctorId', $doctorId);
        }

        $appointments = $queryBuilder->getQuery()->getResult();

        $appointmentsArray = [];
        foreach ($appointments as $appointment) {
            $doctor = $appointment->getDoctor();
            $doctorUser = $doctor->getUser();
            $doctorUserDetails = $doctorUser->getUserDetails();

            $appointmentsArray[] = [
                'id' => $appointment->getId(),
                'date' => $appointment->getDate()->format('Y-m-d H:i'),
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
    #[Route('/api/doctors-details', name: 'api_doctors_details', methods: ['GET'])]
    public function getDoctorsWithDetails(EntityManagerInterface $em): Response
    {
        $repository = $em->getRepository(Doctor::class);
        $doctors = $repository->findAll();
        $doctorsWithDetails = [];

        foreach ($doctors as $doctor) {
            $user = $doctor->getUser();
            $doctorsWithDetails[] = [
                'id' => $doctor->getId(),
                'user' => [
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'name' => $user->getName(),
                    'surname' => $user->getSurname(),
                    'phone' => $user->getPhone(),
                ],
            ];
        }
        return $this->json($doctorsWithDetails);
    }
   
}
