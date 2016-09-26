<?php

/*
@Author: Maxime Allanic <mallanic>
@Date:   21/09/2016
@Email:  maxime@allanic.me
@Last modified by:   mallanic
@Last modified time: 26/09/2016
*/
namespace RedkeetBundle\Controller;

use DateTime;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Tests\Extension\Core\Type\DateTimeTypeTest;

use Symfony\Component\HttpFoundation\Request;

use RedkeetBundle\Entity\Event;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @param Request $request
		 * @return string
     */
    public function indexAction(Request $request)
    {
      /* Make an Event Object and Transform it to a form */
			$event = new Event();
      $form = $this->createFormBuilder($event)
				->add('name')
				->add('date')
        ->add('add', SubmitType::class, array('label' => "Ajouter"))
				->getForm();

      $form->handleRequest($request);

      /* If Form is Submitted and Valid, persist it into DB */
      if ($form->isSubmitted() && $form->isValid()) {
				$task = $form->getData();

				$em = $this->getDoctrine()->getManager();

		    // tells Doctrine you want to (eventually) save the Product (no queries yet)
		    $em->persist($task);

		    // actually executes the queries (i.e. the INSERT query)
		    $em->flush();
        return $this->redirectToRoute('events');
      }
      return $this->render('RedkeetBundle:Default:index.html.twig', array(
        "form" => $form->createView()
      ));
    }

    /**
     *  @Route("/event", name="events")
     */
    public function eventsAction(Request $request)
    {
      /* List All Events **/
			$events =  $this->getDoctrine()
        ->getRepository('RedkeetBundle:Event')
        ->findAll();

      return $this->render('RedkeetBundle:Default:events.html.twig', array(
        "events" => $events
      ));
    }
}
