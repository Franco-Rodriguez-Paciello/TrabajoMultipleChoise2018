<?php

namespace App\Controller;



use Symfony\Component\Yaml\Yaml;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/default", name="default")
     */
    public function index()
    {	
    	$Archivo_parseado = Yaml::parseFile(__DIR__.'/preguntas.yml');
    	// dump($Archivo_parseado["preguntas"][0]);
        dump($Archivo_parseado);


        return $this->render('default/index.html.twig', ['controller_name' => 'DefaultController',] , array('pregunta' => $Archivo_parseado);
    }
}
