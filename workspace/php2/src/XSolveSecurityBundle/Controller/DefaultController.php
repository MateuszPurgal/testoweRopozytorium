<?php

namespace XSolveSecurityBundle\Controller;
use XSolveSecurityBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
class DefaultController extends Controller {

    public function indexAction() {

        return $this->render('XSolveSecurityBundle:Default:index.html.twig');
    }
    public function loginAction() {
        $request = $this->getRequest();
        $session = $request->getSession();
        

           
        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(
                    SecurityContext::AUTHENTICATION_ERROR
            );
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render(
                        'XSolveSecurityBundle:Security:login.html.twig', array(
                    // last username entered by the user
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error,
                        )
        );
    }
    public function adminUsersAction() {
        
    $product = $this->getDoctrine()
        ->getRepository('XSolveSecurityBundle:User')
        ->findAll();

        return $this->render('XSolveSecurityBundle:Default:adminUsers.html.twig', array(
                    'table' => $product
                        ));
    }
    public function page1Action() {
        return $this->render('XSolveSecurityBundle:Default:page1.html.twig');
    }
    public function page2Action() {
        return $this->render('XSolveSecurityBundle:Default:page2.html.twig');
    }
    public function page3Action() {
        return $this->render('XSolveSecurityBundle:Default:page3.html.twig');
    }
    public function PanelAdminAction() {
        return $this->render('XSolveSecurityBundle:Default:admin.html.twig');
    }
    public function registerAction(Request $request){
        $username = $form["username"]->getData();
        $password = $form["password"]->getData();

        // create a task and give it some dummy data for this example
        $task = new User();
        $task->setUsername('user');
        $task->setPassword('user');
        
        $form = $this->createFormBuilder($task)
            ->add('username', 'text')
            ->add('password', 'text')
            ->add('save', 'submit')
            ->getForm();
        $form->handleRequest($request);
        
        if ($form->isValid()) {
        // perform some action, such as saving the task to the database
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();
        return $this->redirect($this->generateUrl('login'));
        }
        
        
        return $this->render('XSolveSecurityBundle:Security:register.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    public function ShowUserAction($id) {

      $user = $this->getDoctrine()
	      ->getRepository('XSolveSecurityBundle:User')
	      ->find($id);

      if (!$user) {
	 throw $this->createNotFoundException(
		 'No product user for id ' . $id
	 );
      }
      return $this->render('XSolveSecurityBundle:Default:showUser.html.twig', array(
		  'user' => $user
      ));
   }

}


