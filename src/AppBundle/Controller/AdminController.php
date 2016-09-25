<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Breed;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/", name="admin-home")
     */
    public function indexAction(Request $request)
    {

        $breeds = $this->getDoctrine()->getRepository(Breed::class)->findAll();

        return $this->render('AppBundle:breeds:list.html.twig', [
            'breeds' => $breeds
        ]);
    }

    /**
     * @Route("/{slug}", name="admin-show")
     */
    public function breedShowAction(Breed $breed)
    {
        return $this->render('AppBundle:breeds:show.html.twig', [
            'breed' => $breed
        ]);
    }


}
