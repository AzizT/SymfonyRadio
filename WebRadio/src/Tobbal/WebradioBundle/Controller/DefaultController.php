<?php

namespace Tobbal\WebradioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@TobbalWebradio/Default/index.html.twig');
    }
}
