<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Kitty;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/kitties")
 */
class KittyController extends Controller
{
    /**
     * @Route("/{page}", name="kitty-list", requirements={"page": "\d+"})
     */
    public function indexAction(Request $request, $page = 1)
    {

        $limit = 300;

        $kitties = $this->getDoctrine()->getRepository(Kitty::class)->paginate($page, $limit);

        $maxPages = ceil($kitties->count() / $limit);

        return $this->render('AppBundle:kitties:list.html.twig', [
            'kitties' => $kitties,
            'maxPages' => $maxPages,
            'thisPage' => $page
        ]);
    }

    /**
     * @Route("/{slug}", name="kitty-show")
     */
    public function kittyShowAction(Kitty $kitty)
    {

        $imageFinder = $this->get('app.kittyimages');

        $imageLink = $imageFinder->getImageForBreed($kitty->getBreed()->getName());

        return $this->render('AppBundle:kitties:show.html.twig', [
            'kitty' => $kitty,
            'imageLink' => $imageLink
        ]);
    }


}
