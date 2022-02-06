<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Concert;
use App\Form\ConcertType;
use DateTime;

class ConcertController extends AbstractController
{
    /**
     * Display incoming concert list
     * @Route("/", name="incoming_concert")
     */
    public function getIncomingConcerts(): Response
    {
        $allConcerts = $this->getDoctrine()->getRepository(Concert::class)->findAll();
        $incomingConcerts = array();

        $currentDate = new DateTime('now');

        foreach($allConcerts as $concert){
            if($concert->getDate() > $currentDate){
                $incomingConcerts[] = $concert;
            }
        }

        return $this->render('concert/home.html.twig', [
            'concerts' => $incomingConcerts,
        ]);
    }

    /**
     * Display concert by id
     * @Route("/concert/{id}", name="concert_show")
     */
    public function getConcertById(int $id): Response
    {
        $concert = $this->getDoctrine()->getRepository(Concert::class)->find($id);

        return $this->render('concert/show.html.twig', [
            'concert' => $concert
        ]);
    }

    /**
     * Display concert list
     * @Route("/concerts/crud", name="concert_list")
     * @isGranted("ROLE_ADMIN")
     */
    public function getConcerts(): Response
    {
        $concerts = $this->getDoctrine()->getRepository(Concert::class)->findAll();

        return $this->render('concert/concertList.html.twig', [
            'concerts' => $concerts,
        ]);
    }

    /**
     * Display archived concert list
     * @Route("/archives", name="archives")
     */
    public function getArchives(): Response
    {
        $allConcerts = $this->getDoctrine()->getRepository(Concert::class)->findAll();
        $pastConcerts = array();

        $currentDate = new DateTime('now');

        foreach($allConcerts as $concert){
            if($concert->getDate() < $currentDate){
                $pastConcerts[$concert->getDate()->format("Y")][] = $concert;
            }
        }

        return $this->render('concert/archives.html.twig', [
            'concerts' => $pastConcerts,
        ]);
    }

    /**
     * Create concert entity
     * @Route("/concerts/create", name="concert_create")
     * @isGranted("ROLE_ADMIN")
     */
    public function createConcert(Request $request): Response
    {
        $concert = new Concert();

        $form = $this->createForm(ConcertType::class, $concert);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $concert = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($concert);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'The concert has been created !'
            );

            return $this->redirectToRoute('concert_list');
        }

        return $this->render('concert/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete concert entity
     * @Route("/concert/delete/{id}", name="concert_delete")
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteConcert(Request $request, Concert $concert): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($concert);
        $entityManager->flush();

        return $this->redirectToRoute('concert_list');
    }

    /**
     * Edit concert entity
     * @Route("/concert/edit/{id}", name="concert_edit")
     * @isGranted("ROLE_ADMIN")
     */
    public function updateConcert(Request $request, int $id): Response
    {
        $concert = $this->getDoctrine()->getRepository(Concert::class)->find($id);

        $form = $this->createForm(ConcertType::class, $concert);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $concert = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'The concert has been edited !'
            );

            return $this->redirectToRoute('concert_list');
        }

        return $this->render('concert/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
