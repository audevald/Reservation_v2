<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Entity\ReservationSearch;
use App\Form\ReservationSearchType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use App\Form\ReservationHistorySearchType;
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

    /**
     * @var EntityManagerInterface
     */
    private $em;


    public function __construct(ReservationRepository $repository, PaginatorInterface $paginator, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->paginator = $paginator;
        $this->em = $em;
    }

    /**
     * @Route("/admin/reservations/confirmation", name="admin.reservation.confirmation")
     * @return Response
     */
    public function listUnconfirm(Request $request)
    {
        $reservations = $this->paginator->paginate(
            $this->repository->findAllResaUnconfirmedQuery(),
            $request->query->getInt('otherPage', 1),
            10,
            ['pageParameterName' => 'otherPage']
        );
        return $this->render('admin/reservation/confirmation.html.twig', [
            'current_menu' => 'reservation.confirmation',
            'reservations' => $reservations
        ]);
    }

    

    /**
     * @Route("/admin/reservations/gestion", name="admin.reservation.gestion")
     * @return Response
     */
    public function listGestion(Request $request)
    {
        $search = new ReservationSearch();
        $form = $this->createForm(ReservationSearchType::class, $search);
        $form->handleRequest($request);

        $reservations = $this->paginator->paginate(
            $this->repository->findAllResaConfirmedQuery($search),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/reservation/gestion.html.twig', [
            'current_menu' => 'reservation.gestion',
            'reservations' => $reservations,
            'form' => $form->createView()
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
        $search = new ReservationSearch();
        $form = $this->createForm(ReservationHistorySearchType::class, $search);
        $form->handleRequest($request);

        $reservations = $this->paginator->paginate(
            $this->repository->findAllHistoryQuery($search),
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('admin/reservation/listHistory.html.twig', [
            'current_menu' => 'reservation.history',
            'reservations' => $reservations,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/reservations/ajouter", name="admin.reservation.new")
     */
    public function new(Request $request)
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($reservation);
            $this->em->flush();
            return $this->redirectToRoute('admin.reservation.gestion');
        }

        return $this->render('admin/reservation/new.html.twig', [
            'current_menu' => 'reservation.new',
            'form' => $form->createView()
        ]);
    }
}