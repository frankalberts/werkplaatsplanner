<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Form\AvailabilityType;
use App\Repository\AvailabilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/availability")
 */
class AvailabilityController extends AbstractController
{
    /**
     * @Route("/", name="availability_index", methods="GET")
     */
    public function index(AvailabilityRepository $availabilityRepository): Response
    {
        return $this->render('availability/index.html.twig', ['availabilities' => $availabilityRepository->findAll()]);
    }

    /**
     * @Route("/new", name="availability_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $availability = new Availability();
        $form = $this->createForm(AvailabilityType::class, $availability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($availability);
            $em->flush();

            return $this->redirectToRoute('availability_index');
        }

        return $this->render('availability/new.html.twig', [
            'availability' => $availability,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="availability_show", methods="GET")
     */
    public function show(Availability $availability): Response
    {
        return $this->render('availability/show.html.twig', ['availability' => $availability]);
    }

    /**
     * @Route("/{id}/edit", name="availability_edit", methods="GET|POST")
     */
    public function edit(Request $request, Availability $availability): Response
    {
        $form = $this->createForm(AvailabilityType::class, $availability);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('availability_index', ['id' => $availability->getId()]);
        }

        return $this->render('availability/edit.html.twig', [
            'availability' => $availability,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="availability_delete", methods="DELETE")
     */
    public function delete(Request $request, Availability $availability): Response
    {
        if ($this->isCsrfTokenValid('delete'.$availability->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($availability);
            $em->flush();
        }

        return $this->redirectToRoute('availability_index');
    }
}
