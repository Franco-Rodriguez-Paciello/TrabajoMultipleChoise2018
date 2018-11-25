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
         
        $RTA = $this->Mezclador($Preguntas)[0];
        $Preguntas=$this->Mezclador($Preguntas)[1];
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

        $Ordenpreg = Yaml::dump($Preguntas);

        file_put_contents(__DIR__.'/nombrearchivopregultexam.yml', $Ordenpreg);

        $Ordenrta = Yaml::dump($RTA);

        file_put_contents(__DIR__.'/nombrearchivortaultexam.yml', $Ordenrta);

        return [$RTA,$Preguntas];

    }

     public function RTA(){

        if(file_exists( __DIR__.'/nombrearchivopregultexam.yml') ){

            $Preguntas = $this->Parseador("/nombrearchivopregultexam.yml");
            $Respuestas = $this->Parseador("/nombrearchivortaultexam.yml");
            $cant_preguntas=count($Preguntas);
            $cant_preguntas=$cant_preguntas-1;
            return $this->render('default/rta.html.twig', ["preguntas" => $Preguntas, "RTA" => $Respuestas,"cant_preguntas"=>$cant_preguntas]);
        }
        else{
            return False;
        }

    }

     public function Parseador($Archivo){
        $Archivo_parseado = Yaml::parseFile(__DIR__.'/'.$Archivo);

        return $Archivo_parseado;
    }
}