<?php

namespace App\Controller;

use App\Entity\Club;
use App\Form\ClubType;
use App\Repository\ClubRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/club')]
class ClubController extends AbstractController
{
    #[Route('/', name: 'app_club_index', methods: ['GET'])]
    public function index(ClubRepository $clubRepository): Response
    {

        return $this->render('club/index.html.twig', [
            'clubs' => $clubRepository->findAll(),
        ]);
    }

    #[Route('/front', name: 'app_club_index', methods: ['GET'])]
    public function indexfront(ClubRepository $clubRepository): Response
    {
        return $this->render('club/indexFront.html.twig', [
            'clubs' => $clubRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_club_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $club = new Club();
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('LogoClub')->getData();

            if ($file) {
                $fileContent = file_get_contents($file->getPathname());
                $club->setLogoClub($fileContent);
            }
            $entityManager->persist($club);
            $entityManager->flush();

            return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('club/new.html.twig', [
            'club' => $club,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_club_show', methods: ['GET'])]
    public function show(Club $club): Response
    {
        return $this->render('club/show.html.twig', [
            'club' => $club,
        ]);
    }

    #[Route('/front/{id}', name: 'app_club_showFront', methods: ['GET'])]
    public function showFront(Club $club): Response
    {
        return $this->render('club/showFront.html.twig', [
            'club' => $club,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_club_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Club $club, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ClubType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('club/edit.html.twig', [
            'club' => $club,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_club_delete', methods: ['POST'])]
    public function delete(Request $request, Club $club, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$club->getId(), $request->request->get('_token'))) {
            $entityManager->remove($club);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_club_index', [], Response::HTTP_SEE_OTHER);
    }
}
