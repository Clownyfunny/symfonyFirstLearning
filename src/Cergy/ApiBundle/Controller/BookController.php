<?php

namespace Cergy\ApiBundle\Controller;

use Cergy\BookBundle\Form\Type\BookType;
use FOS\RestBundle\Controller\FOSRestController as Controller;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{
    public function getBookAction(){
        $book = $this->getDoctrine()->getRepository('CergyBookBundle:Book')->findAll();
        return $this->handleView($this->view($book));
    }

    public function postBookAction(Request $request){
        $form = $this->get('form.factory')->createNamed('form', new BookType(), null, [
            'csrf_protection' => false,
            'method' => $request->getMethod()
        ]);

        $form->handleRequest($request);
        if ($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData());
            $em->flush();

            return $this->handleView($this->view(null, Codes::HTTP_CREATED));
        }
        return $this->handleView($this->view([
            'error' => (string) $form->getErrors()
        ], Codes::HTTP_BAD_REQUEST));
    }
}
