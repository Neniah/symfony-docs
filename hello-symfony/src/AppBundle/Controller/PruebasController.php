<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PruebasController extends Controller
{
  /*
  *  @Route()
  */
  public functionindexAction(Request $request){

    return $this->render('AppBundle:Pruebas:index.html.twig', away(
      'comment' => 'I send you this from Action Controller.';
    ));
  }

}
?>
