<?php

namespace XSolveSecurityBundle\Controller;
use XSolveSecurityBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller {

public function ShowUserAction($id)
{
    $user = $this->getDoctrine()
        ->getRepository('XSolveSecurityBundle:User')
        ->find($id);

    if (!$user) {
        throw $this->createNotFoundException(
            'No product user for id '.$id
        );

    }


    return $this->render('XSolveSecurityBundle:Default:showUser.html.twig', array(
                    'user' => $user
                        ));
    // ... do something, like pass the $product object into a template
}


}


