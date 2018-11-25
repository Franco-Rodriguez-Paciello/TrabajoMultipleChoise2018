<?php

namespace App\Controller;



use Symfony\Component\Yaml\Yaml;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
   public function index()
    {
        $Archivo_parseado=$this->Parseador("preguntas.yml");

        $Preguntas = $Archivo_parseado["preguntas"];

        $RTA = $this->Mezclador($Preguntas);

        $cant_preguntas=count($Preguntas);
        $cant_preguntas=$cant_preguntas-1;

        return $this->render('default/index.html.twig', [
            'preguntas' => $Preguntas,"cant_preguntas" => $cant_preguntas,"RTA" => $RTA]);
    }

    public function Mezclador($Preguntas){
        $Preguntas=shuffle($Preguntas);

        $RTA=[];
        foreach ($Preguntas as $pregunta ) {

            $mezclar_preg = array_merge($pregunta["respuestas_correctas"],$pregunta["respuestas_incorrectas"]);
            shuffle($mezclar_preg);
            $RTA[]=$mezclar_preg;

        }

        $Ordenpreg = Yaml::dump($Preguntas);

        file_put_contents(DIR.'/nombrearchivopregultexam.yml', $Ordenpreg);

        $Ordenrta = Yaml::dump($RTA);

        file_put_contents(DIR.'/nombrearchivortaultexam.yml', $Ordenrta);

        return $RTA;

    }

     public function RTA(){

        if(file_exists( DIR.'/nombrearchivopregultexam.yml') ){

            $Preguntas = $this->Parsear_Archivo("/nombrearchivopregultexam.yml");
            $Respuestas = $this->Parsear_Archivo("/nombrearchivortaultexam.yml");

            return $this->render('default/ViewMostrarRtas.html.twig', ["preguntas" => $Preguntas, "Respuestas_mezcladas" => $Respuestas]);
        }
        else{
            return False;
        }

    }

     public function Parseador($Archivo){
        $Archivo_parseado = Yaml::parseFile(DIR.'/'.$Archivo);

        return $Preguntas;
    }
}