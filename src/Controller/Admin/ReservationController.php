<?php

namespace App\Controller\Admin;

use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController {

    /**
     * @var ReservationRepository
     */
    private $repository;

    public function __construct(ReservationRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin/reservations/gestion", name="admin.reservation.gestion")
     * @return Response
     */
    public function listsGestion()
    {
        $confirmed = $this->repository->findAllResa(true);
        $unconfirmed = $this->repository->findAllResa(false);
        return $this->render('admin/reservation/gestion.html.twig', [
            'current_menu' => 'reservation.gestion',
            'confirmed' => $confirmed,
            'unconfirmed' => $unconfirmed
        ]);
    }

    /**
     * @Route("/admin/reservations/midi", name="admin.reservation.listDayLunch")
     * @return Response
     */
    public function listDayLunch()
    {
        $reservations = $this->repository->findAllDayLunchConfirm();
        return $this->render('admin/reservation/listDayLunch.html.twig', [
            'current_menu' => 'reservation.listDayLunch',
            'reservations' => $reservations
        ]);
    }

    /**
     * @Route("/admin/reservations/soir", name="admin.reservation.listDayEvening")
     * @return Response
     */
    public function listDayEvening()
    {
        $reservations = $this->repository->findAllDayEveningConfirm();
        return $this->render('admin/reservation/listDayEvening.html.twig', [
            'current_menu' => 'reservation.listDayEvening',
            'reservations' => $reservations
        ]);
    }
    
}