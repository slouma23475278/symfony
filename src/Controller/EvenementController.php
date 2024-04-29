<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }
    #[Route('/stat', name: 'app_evenement_stat', methods: ['GET'])]
    public function eventStatistics(EvenementRepository $evenementRepository): Response
    {
        // Existing statistics
        $eventCountByType = $evenementRepository->countEventsByType();
        $totalEvents = $evenementRepository->countTotalEvents();
        $upcomingEvents = $evenementRepository->findUpcomingEvents();

        // New statistics for confirmed and not confirmed events
        $confirmedEvents = $evenementRepository->countConfirmedEvents();
        $notConfirmedEvents = $evenementRepository->countNotConfirmedEvents();

        return $this->render('evenement/event_statistics.html.twig', [
            'eventCountByType' => $eventCountByType,
            'totalEvents' => $totalEvents,
            'upcomingEvents' => $upcomingEvents,
            'confirmedEvents' => $confirmedEvents,
            'notConfirmedEvents' => $notConfirmedEvents,
        ]);
    }
    #[Route('/back', name: 'app_evenement_indexBack', methods: ['GET'])]
    public function indexback(EvenementRepository $evenementRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $events = $evenementRepository->findAll();
        $pagination = $paginator->paginate(
            $events, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render('evenement/indexBack.html.twig',   ['pagination' => $pagination]
        );
    }

    #[Route('/newback', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request,MailerInterface $mailer, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFile = $form->get('lienFichier')->getData();

            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();

                try {
                    $pictureFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception
                }
                $evenement->setLienFichier($newFilename);
                $evenement->setStatus(0);
            }


            $entityManager->persist($evenement);
//            $email = (new Email())
//                ->from('ines.rouatbi14@gmail.com')
//                ->to('farouk.chalghoumi031@gmail.com')
//                //->cc('cc@example.com')
//                //->bcc('bcc@example.com')
//                //->replyTo('fabien@example.com')
//                ->priority(Email::PRIORITY_HIGH)
//                ->subject('Time for Symfony Mailer!')
//                ->text('Sending emails is fun again!')
//                ->html('<p>See Twig integration for better HTML integration!</p>');
//
//            try {
//                $mailer->send($email);
//            } catch (TransportExceptionInterface $e) {
//                // some error prevented the email sending; display an
//                // error message or try to resend the message
//                //make errors
//
//            }
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_indexBack', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/new', name: 'app_evenement_newFront', methods: ['GET', 'POST'])]
    public function newfront(Request $request,MailerInterface $mailer, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFile = $form->get('lienFichier')->getData();
            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();

                try {
                    $pictureFile->move(
                        $this->getParameter('upload_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // handle exception
                }
                $evenement->setLienFichier($newFilename);
            }

            $evenement->setStatus(0);
            $entityManager->persist($evenement);

            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/new_front.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/confirm', name: 'app_evenement_confirm', methods: ['GET', 'POST'])]
    public function confirmEvent(Request $request,MailerInterface $mailer, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
//        $form = $this->createForm(EvenementType::class, $evenement);
//        $form->handleRequest($request);
        if ($evenement->isStatus() )
        {
            return $this->redirectToRoute('app_evenement_indexBack', [], Response::HTTP_SEE_OTHER);
        }

        $evenement->setStatus(1);
        $email = (new Email())
            ->from('ines.rouatbi14@gmail.com')
            ->to('farouk.chalghoumi031@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Event Confirmation!')
            ->text('Event is confirmed by admin!')
            ->html('<p>Hello again User your event is successfully confirmed by admin than you for your contribution !</p>');

        try {
            $mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            // some error prevented the email sending; display an
            // error message or try to resend the message
            //make errors

        }
        $entityManager->flush();

        return $this->redirectToRoute('app_evenement_indexBack', [], Response::HTTP_SEE_OTHER);

    }

    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_indexBack', [], Response::HTTP_SEE_OTHER);
    }

}
