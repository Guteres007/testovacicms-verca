<?php

namespace Andrasi\TestBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TestController extends AbstractController {


    public function index()
    {
        return new Response('Ok');
    }

}
