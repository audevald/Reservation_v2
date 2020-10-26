<?php

namespace App\Controller\Admin;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\ORM\EntityManagerInterface;
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
                'message' => 'Clients à table'
            ], 200);
        }
        $reservation->setClientArrived(false);
        $this->em->persist($reservation);
        $this->em->flush();
        return $this->json([
            'code' => 200,
            'message' => 'Clients pas à table'
        ], 200);
    }
}