<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function contactAction(Request $request)
    {

        $message = new Message();

        $form = $this->createForm(ContactType::class, $message);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $message = $form->getData();

            return $this->redirectToRoute('contact-success');
        }

        return $this->render('AppBundle:contact:contact.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/contact-success", name="contact-success")
     */
    public function contactSuccessAction(Request $request)
    {

        return $this->render('AppBundle:contact:contact-success.html.twig');
    }

}
