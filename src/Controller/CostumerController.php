<?php

namespace App\Controller;

use App\Entity\Costumer;
use App\Form\CostumerType;
use App\Repository\CostumerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/costumer")
 */
class CostumerController extends AbstractController
{
    /**
     * @Route("/", name="costumer_index", methods="GET")
     */
    public function index(CostumerRepository $costumerRepository): Response
    {
        return $this->render('costumer/index.html.twig', ['costumers' => $costumerRepository->findAll()]);
    }

    /**
     * @Route("/new", name="costumer_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $costumer = new Costumer();
        $form = $this->createForm(CostumerType::class, $costumer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($costumer);
            $em->flush();

            return $this->redirectToRoute('costumer_index');
        }

        return $this->render('costumer/new.html.twig', [
            'costumer' => $costumer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="costumer_show", methods="GET")
     */
    public function show(Costumer $costumer): Response
    {
        return $this->render('costumer/show.html.twig', ['costumer' => $costumer]);
    }

    /**
     * @Route("/{id}/edit", name="costumer_edit", methods="GET|POST")
     */
    public function edit(Request $request, Costumer $costumer): Response
    {
        $form = $this->createForm(CostumerType::class, $costumer);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('costumer_index', ['id' => $costumer->getId()]);
        }

        return $this->render('costumer/edit.html.twig', [
            'costumer' => $costumer,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="costumer_delete", methods="DELETE")
     */
    public function delete(Request $request, Costumer $costumer): Response
    {
        if ($this->isCsrfTokenValid('delete'.$costumer->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($costumer);
            $em->flush();
        }

        return $this->redirectToRoute('costumer_index');
    }
}
