<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Band;
use App\Entity\Concert;
use Symfony\Component\HttpFoundation\Request;
use App\Form\BandType;
use DateTime;

class BandController extends AbstractController
{
    /**
     * CRUD band
     * @Route("/bands/crud", name="bands_crud")
     * @isGranted("ROLE_ADMIN")
     */
    public function crudBands(): Response
    {
        $bands = $this->getDoctrine()->getRepository(Band::class)->findAll();

        return $this->render('band/crud.html.twig', [
            'bands' => $bands,
        ]);
    }

    /**
     * Display bands list
     * @Route("/bands", name="band_list")
     */
    public function getBands(): Response
    {
        $bands = $this->getDoctrine()->getRepository(Band::class)->findAll();

        return $this->render('band/list.html.twig', [
            'bands' => $bands,
        ]);
    }

    /**
     * Display band by id
     * @Route("/band/{id}", name="band_show")
     */
    public function getBandById(int $id): Response
    {
        $band = $this->getDoctrine()->getRepository(Band::class)->find($id);
        
        $bandConcerts = $this->getDoctrine()->getRepository(Concert::class)->findByBand($id);
        $futureConcerts = array();

        $currentDate = new DateTime('now');

        foreach($bandConcerts as $concert){
            if($concert->getDate() > $currentDate){
                $futureConcerts[] = $concert;
            }
        }

        return $this->render('band/show.html.twig', [
            'band' => $band,
            'futureConcerts' => $futureConcerts
        ]);
    }

    /**
     * Create band
     * @Route("/bands/create", name="bands_create")
     * @isGranted("ROLE_ADMIN")
     */
    public function createBand(Request $request): Response
    {
        $band = new Band();

        $form = $this->createForm(BandType::class, $band);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $band = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($band);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'The band has been created !'
            );

            return $this->redirectToRoute('band_list');
        }

        return $this->render('band/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete band entity
     * @Route("/bands/delete/{id}", name="bands_delete")
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteBand(Request $request, Band $band): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($band);
        $entityManager->flush();

        return $this->redirectToRoute('band_list');
    }

    /**
     * Edit band entity
     * @Route("/bands/edit/{id}", name="bands_edit")
     * @isGranted("ROLE_ADMIN")
     */
    public function updateBand(Request $request, int $id): Response
    {
        $band = $this->getDoctrine()->getRepository(Band::class)->find($id);

        $form = $this->createForm(BandType::class, $band);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $band = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'The band has been edited !'
            );

            return $this->redirectToRoute('band_list');
        }

        return $this->render('band/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
