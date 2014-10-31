<?php

namespace Acme\WechatSDKBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AcmeWechatSDKBundle:Default:index.html.twig', array('name' => $name));
    }
}
