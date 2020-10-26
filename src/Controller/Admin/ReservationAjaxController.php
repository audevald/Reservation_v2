<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationAjaxController extends AbstractController {

    /**
     * @var ReservationRepository
     */
    private $repository;

    /**
     * @var EntityManagerInterface
     */
    private $em;


    public function __construct(ReservationRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * Définie si la réservation est confirmée ou non
     *
     * @Route("admin/reservations/{id}/confirm", name="reservation.confirm")
     * @return Response
     */
    public function confirm(Reservation $reservation): Response
    {
        if (!$reservation->getConfirm()) {
            $reservation->setConfirm(true);
            $this->em->persist($reservation);
            $this->em->flush();
            return $this->json([
                'code' => 200,
                'message' => 'Réservation bien confirmée'
            ], 200);
        }
        $reservation->setConfirm(false);
        $this->em->persist($reservation);
        $this->em->flush();
        return $this->json([
            'code' => 200, 
            'message' => 'Confirmation de la réservation annulée'
        ], 200);
    }
    
    /**
     * Définie si les clients sont arrivés ou pas
     *
     * @Route("admin/reservations/jour/{id}/arrived", name="reservation.arrived")
     * @return Response
     */
    public function arrived(Reservation $reservation): Response
    {
        if (!$reservation->getClientArrived()) {
            $reservation->setClientArrived(true);
            $this->em->persist($reservation);
            $this->em->flush();
            return $this->json([
                'code' => 200,
                'message' => 'A table'
            ], 200);
        }
        $reservation->setClientArrived(false);
        $this->em->persist($reservation);
        $this->em->flush();
        return $this->json([
            'code' => 200,
            'message' => 'En attente'
        ], 200);
    }
}