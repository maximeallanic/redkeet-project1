<?php

/*
@Author: Maxime Allanic <mallanic>
@Date:   21/09/2016
@Email:  maxime@allanic.me
@Last modified by:   mallanic
@Last modified time: 21/09/2016
*/
namespace RedkeetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     */
    public function indexAction()
    {
      $now = new DateTime();
      $christmas = new DateTime($now->format('Y')."-12-24 0:0:0");
      $diff = $now->diff($christmas);

      if ($diff->format('%R') == '-')
        $christmas->setDate($christmas->format('Y') + 1, $christmas->format('m'), $christmas->format('d'));
      return $this->render('RedkeetBundle:Default:index.html.twig', array(
        "christmas" => $christmas
      ));
    }

    /**
     *  @Route("/christmas", name="christmas")
     */
    public function christmasAction(Request $request)
    {
      $christmasTimeLeft = $request->get('christmas');
      return $this->render('RedkeetBundle:Default:christmas.html.twig', array(
        "christmas" => $christmasTimeLeft
      ));
    }
}
