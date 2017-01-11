<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Todo;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extention\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TodoController extends Controller
{
    /**
     * @Route("/todos", name="todo_list")
     */
    public function listAction()
    {
        $todos = $this->getDoctrine()
          ->getRepository('AppBundle:Todo')
          ->findAll();
        // replace this example code with whatever you need
        return $this->render('todo/index.html.twig', array(
          'todos' => $todos
        ));
    }

    /**
     * @Route("/todos/create", name="todo_create")
     */
    public function createAction(Request $request)
    {
        $todo = new Todo;
        $form = $this->createFormBuilder($todo)
          ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
          ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
          ->add('description', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
          ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Nomal' => 'Normal', 'High' => 'High'),'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
          ->add('due_date', DateType::class, array('attr' => array( 'style' => 'margin-bottom:15px')))
          ->add('save', SubmitType::class, array('label' => 'Create todo', 'attr' => array('class' => 'btn btn-success btn-block', 'style' => 'margin-bottom:15px')))
          ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ){
          //Get Data
          $name = $form['name']->getData();
          $category = $form['category']->getData();
          $description = $form['description']->getData();
          $priority = $form['priority']->getData();
          $due_date = $form['due_date']->getData();

          $now = new\DateTime('now');
          $todo->setName($name);
          $todo->setCategory($category);
          $todo->setDescription($description);
          $todo->setPriority($priority);
          $todo->setDueDate($due_date);
          $todo->setCreateDate($now);

          $em = $this->getDoctrine()->getManager();
          $em->persist($todo);
          $em->flush();

          $this->addFlash(
            'notice', 'Todo Added'
          );

          return $this->redirectToRoute('todo_list');
        }
        // replace this example code with whatever you need
        return $this->render('todo/create.html.twig', array('form' => $form->createView()));
    }
    /**
     * @Route("/todos/edit/{id}", name="todo_edit")
     */
    public function editAction($id, Request $request)
    {
        $todo = $this->getDoctrine()
          ->getRepository('AppBundle:Todo')
          ->find($id);

          $todo->setName($todo->getName());
          $todo->setCategory($todo->getCategory());
          $todo->setDescription($todo->getDescription());
          $todo->setPriority($todo->getPriority());
          $todo->setDueDate($todo->getDueDate());


          $form = $this->createFormBuilder($todo)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('category', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('description', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('priority', ChoiceType::class, array('choices' => array('Low' => 'Low', 'Nomal' => 'Normal', 'High' => 'High'),'attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('due_date', DateType::class, array('attr' => array( 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Update todo', 'attr' => array('class' => 'btn btn-success btn-block', 'style' => 'margin-bottom:15px')))
            ->getForm();

          $form->handleRequest($request);

          if($form->isSubmitted() && $form->isValid() ){
            //Get Data
            $name = $form['name']->getData();
            $category = $form['category']->getData();
            $description = $form['description']->getData();
            $priority = $form['priority']->getData();
            $due_date = $form['due_date']->getData();

            $now = new\DateTime('now');

            $em = $this->getDoctrine()->getManager();
            $todo = $em->getRepository('AppBundle:Todo')->find($id);

            $todo->setName($name);
            $todo->setCategory($category);
            $todo->setDescription($description);
            $todo->setPriority($priority);
            $todo->setDueDate($due_date);
            $todo->setCreateDate($now);

            $em->flush();
            $this->addFlash(
              'notice', 'Todo Updated'
            );

            return $this->redirectToRoute('todo_list');
          }
        // replace this example code with whatever you need
        return $this->render('todo/edit.html.twig', array(
          'todo' => $todo,
          'form' => $form->createView()
        ));
    }


    /**
     * @Route("/todos/details/{id}", name="todo_details")
     */
    public function detailsAction($id)
    {
      $todo = $this->getDoctrine()
        ->getRepository('AppBundle:Todo')
        ->find($id);
      // replace this example code with whatever you need
      return $this->render('todo/details.html.twig', array(
        'todo' => $todo
      ));
    }

    /**
     * @Route("/todos/delete/{id}", name="todo_delete")
     */
    public function deleteAction($id)
    {
      $em = $this->getDoctrine()->getManager();
      $todo = $em->getRepository('AppBundle:Todo')->find($id);

      $em->remove($todo);
      $em->flush();
      $this->addFlash(
        'notice', 'Todo Removed'
      );

      return $this->redirectToRoute('todo_list');
    }
}
