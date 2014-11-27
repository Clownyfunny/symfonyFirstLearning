<?php

namespace Cergy\BookBundle\Controller;

use Cergy\BookBundle\Form\Type\BookType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class BookController extends Controller
{
    /**
     * @Route("/", name="book_list")
     */
    public function indexAction()
    {
        /* Get data informations */
        $book = $this->getDoctrine()->getRepository('CergyBookBundle:Book')->findAll();

        /* Generate view */
        return $this->render('CergyBookBundle:Book:list.html.twig', ['book' => $book]);
    }
    /**
     * @Route("/create")
     */
    /*function for create a book*/
    public function createAction(Request $request)
    {
        $form = $this->createForm(new BookType());

        /*if i send a form in post*/
        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if($form->isValid()){
                $em =$this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'The Book as been added successfully');

                return $this->redirect($this->generateUrl(('book_list')));
            }

        }
        return $this->render('CergyBookBundle:Book:create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/edit/{id}")
     */
    /*function for edit a book*/
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository('CergyBookBundle:Book')->find($id);
        if (!$book) {
            $this->get('session')->getFlashBag()->add('error', 'Book not found');
            return $this->redirect($this->generateUrl(('book_list')));
        }

        $form= $this->createForm(new BookType(), $book);
        if($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'The Book has been updated successfully');
                return $this->redirect($this->generateUrl(('book_list')));
            }
        }

        return $this->render('CergyBookBundle:Book:edit.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/delete/{id}")
     */
    /*function for edit a book*/
    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $book = $em->getRepository('CergyBookBundle:Book')->find($id);
        if (!$book) {
            $this->get('session')->getFlashBag()->add('error', 'Book not found');
            return $this->redirect($this->generateUrl(('book_list')));
        }
        $em->remove($book);
        $em->flush();
        $this->get('session')->getFlashBag()->add('success', 'The Book has been deleted successfully');
        return $this->redirect($this->generateUrl(('book_list')));
    }
}
