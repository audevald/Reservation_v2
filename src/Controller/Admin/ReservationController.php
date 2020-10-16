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
     * @Route("/admin/reservations/toutes", name="admin.reservation.listAll")
     * @return Response
     */
    public function listAll()
    {
        $reservations = $this->repository->findAllConfirm();
        return $this->render('admin/reservation/listAll.html.twig', [
            'current_menu' => 'reservation.list',
            'reservations' => $reservations
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