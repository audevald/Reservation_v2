<?php

namespace App\Controller\Client;

use App\Entity\Reservation;
use App\Form\ReservationClientType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReservationController extends AbstractController {

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
     * @Route("/client/reservation/ajouter", name="client.reservation.new")
     */
    public function new(Request $request)
    {
        $reservation = new Reservation();
        $form = $this->createForm(ReservationClientType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($reservation);
            $this->em->flush();
            return $this->render('client/reservation/confirmation.html.twig', [
                'reservation' => $reservation
            ]);
        }

        return $this->render('client/reservation/new.html.twig', [
            'form' => $form->createView()
        ]);
    }    
}