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
        $Preguntas = $Archivo_parseado["preguntas"];

    	//dump($Archivo_parseado);

        return $this->render('default/index.html.twig', [
            'preguntas' => $Preguntas]);
    }
}
