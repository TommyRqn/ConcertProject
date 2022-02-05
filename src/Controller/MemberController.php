<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Member;
use App\Form\MemberType;

class MemberController extends AbstractController
{
    /**
     * Display concert list
     * @Route("/members/crud", name="members_list")
     * @isGranted("ROLE_ADMIN")
     */
    public function getMembers(): Response
    {
        $members = $this->getDoctrine()->getRepository(Member::class)->findAll();

        return $this->render('member/membersList.html.twig', [
            'members' => $members,
        ]);
    }

    /**
     * Create member
     * @Route("/member/create", name="member_create")
     * @isGranted("ROLE_ADMIN")
     */
    public function createMember(Request $request): Response
    {
        $member = new Member();

        $form = $this->createForm(MemberType::class, $member);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $member = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'The member has been created !'
            );

            return $this->redirectToRoute('members_list');
        }

        return $this->render('member/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete member entity
     * @Route("/member/delete/{id}", name="member_delete")
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteMember(Request $request, Member $member): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($member);
        $entityManager->flush();

        return $this->redirectToRoute('members_list');
    }

    /**
     * Edit member entity
     * @Route("/member/edit/{id}", name="member_edit")
     * @isGranted("ROLE_ADMIN")
     */
    public function updateMember(Request $request, int $id): Response
    {
        $member = $this->getDoctrine()->getRepository(Member::class)->find($id);

        $form = $this->createForm(MemberType::class, $member);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $member = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            $this->addFlash(
                'notice',
                'The member has been edited !'
            );

            return $this->redirectToRoute('members_list');
        }

        return $this->render('member/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
