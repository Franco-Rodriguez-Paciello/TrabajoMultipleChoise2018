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
    public function index($RTA,$Preguntas)
    {	
    	
        $cant_preguntas=count($Preguntas);
        $cant_preguntas=$cant_preguntas-1;

        return $this->render('default/index.html.twig', [
            'preguntas' => $Preguntas,"cant_preguntas" => $cant_preguntas,"RTA" => $RTA]);
    }

    public function Mezclador($Preguntas){
        shuffle($Preguntas);
        $RTA=[];
        foreach ($Preguntas as $pregunta ) {

            $mezclar_preg = array_merge($pregunta["respuestas_correctas"],$pregunta["respuestas_incorrectas"]);
            shuffle($mezclar_preg);
            $RTA[]=$mezclar_preg;

        }
        return $RTA;

    }

     public function Parseador(){
        $Archivo_parseado = Yaml::parseFile(__DIR__.'/preguntas.yml');
        $Preguntas = $Archivo_parseado["preguntas"];

        return $Preguntas;
    }


}
