<?php

namespace Cergy\NewsBundle\Controller;

use Cergy\NewsBundle\Form\Type\NewsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class NewsController extends Controller
{
    /**
     * @Route("/", name="news_list")
     */
    public function indexAction()
    {
        /* Get data informations */
        $news = $this->getDoctrine()->getRepository('CergyNewsBundle:News')->findAll();

        /* Generate view */
        return $this->render('CergyNewsBundle:News:list.html.twig', ['news' => $news]);
    }
    /**
     * @Route("/create")
     */
    /*function for create a news*/
    public function createAction(Request $request)
    {
        $form = $this->createForm(new NewsType());

        /*if i send a form in post*/
        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if($form->isValid()){
                $em =$this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'The News as been added successfully');

                return $this->redirect($this->generateUrl(('news_list')));
            }

        }
        return $this->render('CergyNewsBundle:News:create.html.twig', ['form' => $form->createView()]);
    }
    /**
     * @Route("/edit/{id}")
     */
    /*function for edit a news*/
    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('CergyNewsBundle:News')->find($id);
        if (!$news) {
            $this->get('session')->getFlashBag()->add('error', 'News not found');
            return $this->redirect($this->generateUrl(('news_list')));
        }

        $form= $this->createForm(new NewsType(), $news);
        if($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em->persist($form->getData());
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', 'The News as been updated successfully');
                return $this->redirect($this->generateUrl(('news_list')));
            }
        }

        return $this->render('CergyNewsBundle:News:edit.html.twig', ['form' => $form->createView()]);

    }
}
