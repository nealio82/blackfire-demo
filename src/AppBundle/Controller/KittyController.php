<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Kitty;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Carminato\GoogleCseBundle\Service\ApiRequest;
use Carminato\GoogleCseBundle\Service\Query\ApiQuery;

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

        $apiQuery = new ApiQuery(
            array(
                'key' => $this->container->getParameter('google.api_key'),
                'cx' => $this->container->getParameter('google.search_key'),
                'q' => $kitty->getBreed()->getName() . ' cat',
                'start' => 1,
                'userIp' => $this->getRequest()->getClientIp(),
                'searchType' => 'image'
            )
        );

        $apiRequest = new ApiRequest($apiQuery);

        $response = $apiRequest->getResponse();

        $imageLink = $response->getResults()[0]->getLink();

        return $this->render('AppBundle:kitties:show.html.twig', [
            'kitty' => $kitty,
            'imageLink' => $imageLink
        ]);
    }


}
