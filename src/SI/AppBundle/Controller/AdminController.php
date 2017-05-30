<?php
/**
 * Created by PhpStorm.
 * User: wilder2
 * Date: 29/05/17
 * Time: 14:43
 */

namespace SI\AppBundle\Controller;

use SI\AppBundle\Entity\Benefit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{

    /**
     * Lists all
     *
     * @Route("/indexadmin", name="admin_index")
     * @Method("GET")
     */
    public function listAction()
    {

        return $this->render('Admin/indexadmin.html.twig');
    }

}