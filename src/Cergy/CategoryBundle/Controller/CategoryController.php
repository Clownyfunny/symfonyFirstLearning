<?php

namespace Cergy\CategoryBundle\Controller;

use Cergy\CategoryBundle\Form\Type\CategoryType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @Route("/", name="category_list")
     */
    public function indexAction()
    {
        /* Get data informations */
        $category = $this->getDoctrine()->getRepository('CergyCategoryBundle:Category')->findAll();

        /* Generate view */
        return $this->render('CergyCategoryBundle:Category:index.html.twig', ['category' => $category]);
    }
    /**
     * @Route("/create")
     */
    /*function for create a category*/
    public function createAction(Request $request)
    {
        $form = $this->createForm(new CategoryType());

        /*if i send a form in post*/
        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if($form->isValid()){
                $em =$this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();

                $this->get('session')->getFlashBag()->add('success', 'The Category as been added successfully');

                return $this->redirect($this->generateUrl(('category_list')));
            }

        }
        return $this->render('CergyCategoryBundle:Category:create.hml.twig', ['form' => $form->createView()]);
    }
}
