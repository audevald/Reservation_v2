<?php

namespace App\Controller\Admin;

use App\Repository\ReservationRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController {

    /**
     * @var ReservationRepository
     */
    private $repository;

    /**
     * @var PaginatorInterface
     */
    private $paginator;


    public function __construct(ReservationRepository $repository, PaginatorInterface $paginator)
    {
        $this->repository = $repository;
        $this->paginator = $paginator;
    }

    /**
     * @Route("/admin/reservations/gestion", name="admin.reservation.gestion")
     * @return Response
     */
    public function listsGestion(Request $request)
    {
        $confirmed = $this->paginator->paginate(
            $this->repository->findAllResaQuery(true),
            $request->query->getInt('page', 1),
            10
        );
        $unconfirmed = $this->paginator->paginate(
            $this->repository->findAllResaQuery(false),
            $request->query->getInt('otherPage', 1),
            10,
            ['pageParameterName' => 'otherPage']
        );
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
    public function listDayLunch(Request $request)
    {
        $reservations = $this->paginator->paginate(
            $this->repository->findAllDayLunchConfirmQuery(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('admin/reservation/listDayLunch.html.twig', [
            'current_menu' => 'reservation.listDayLunch',
            'reservations' => $reservations
        ]);
    }

    /**
     * @Route("/admin/reservations/soir", name="admin.reservation.listDayEvening")
     * @return Response
     */
    public function listDayEvening(Request $request)
    {
        $reservations = $this->paginator->paginate(
            $this->repository->findAllDayEveningConfirmQuery(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('admin/reservation/listDayEvening.html.twig', [
            'current_menu' => 'reservation.listDayEvening',
            'reservations' => $reservations
        ]);
    }

    /**
     * @Route("/admin/reservations/historique", name="admin.reservation.history")
     * @return Response
     */
    public function listHistory(Request $request)
    {
        $reservations = $this->paginator->paginate(
            $this->repository->findAllHistoryQuery(),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('admin/reservation/listHistory.html.twig', [
            'current_menu' => 'reservation.history',
            'reservations' => $reservations
        ]);
    }
    
}