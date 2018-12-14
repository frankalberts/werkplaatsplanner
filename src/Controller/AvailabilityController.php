<?php

namespace App\Controller;

use App\Entity\Availability;
use App\Form\AvailabilityType;
use App\Form\BatchAvailabilityType;
use App\Form\CalenderType;
use App\Repository\AvailabilityRepository;
use App\Repository\CalenderRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
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
            try
            {
                $em->flush();
            }
            catch (UniqueConstraintViolationException $exception) {

            }

            return $this->redirectToRoute('availability_index');
        }

        return $this->render('availability/new.html.twig', [
            'availability' => $availability,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/batch", name="availability_batch", methods="GET|POST")
     */
    public function batch(Request $request): Response
    {
        $form = $this->createForm(BatchAvailabilityType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $from = $data['fromdate'];
            $to = $data['todate'];
            $to->modify('+ 1 days');
            $days = $data['days'];

            while ($from < $to) {
                $availability = new Availability();
                if (in_array($from->format('w'), $days))
                {
                    $availability->setBranch($data['branch']);
                    $availability->setWorkdate(clone $from);
                    $availability->setHours($data['hours']);
                    $em->persist($availability);
                }
                $from->modify('+ 1 days');
            }
            $em->flush();
            $em->clear();

            return $this->redirectToRoute('availability_index');
        }return $this->render('availability/batch.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/calender/{month}", name="availability_calender", methods="GET|POST")
     */
    public function calender(CalenderRepository $calenderRepository, Request $request): Response
    {
        $form = $this->createForm(CalenderType::class);
        $form->handleRequest($request);
        $data = $form->getData();
        $month = $request->attributes->get('month');
        $time = new \DateTimeImmutable("2018-" . $month . "-01");

        dump($calenderRepository->findByFiliaal($data["branch"]));
        return $this->render(
            'availability/calender.html.twig', [
                'branch' => $data["branch"],
                'availabilities' => $calenderRepository->findByFiliaal($data["branch"]),
                'month' =>$request->attributes->get('month'),
                'form' => $form->createView(),
                'time' => $time,
            ]
        );
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
