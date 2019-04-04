<?php

namespace SocialProBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ob\HighchartsBundle\Highcharts\Highchart;
use SocialProBundle\Entity;

class GrapheController extends Controller{


    public function PieAction(){

$ob = new Highchart();

$ob->chart->renderTo('piechart');

$ob->title->text('Statistiques Generales ');

$ob->plotOptions->pie(array(

 'allowPointSelect' => true,

 'cursor' => 'pointer',

 'dataLabels' => array('enabled' => false),

 'showInLegend' => true

));
   $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
                "SELECT count(et.taskName)
                 FROM SocialProBundle:Tasks et WHERE et.status ='todo' "
                );
        $Boutique = $query->getSingleScalarResult();
        $et=(int)$Boutique;

        $em1 = $this->getDoctrine()->getManager();
        $query1 = $em1->createQuery(
                "SELECT count(en.taskName)
                 FROM SocialProBundle:Tasks en WHERE en.status ='doing' "
        );
        $Commande = $query1->getSingleScalarResult();
        $en =(int)$Commande;
    $em2 = $this->getDoctrine()->getManager();
    $query2 = $em1->createQuery(
        "SELECT count(en1.taskName)
                 FROM SocialProBundle:Tasks en1 WHERE en1.status ='don' "
    );
    $fff = $query2->getSingleScalarResult();
    $en1 =(int)$fff;
 
        $data = array(
            array('Todo', $et),
            array('Doing', $en),
            array('Done', $en1),

            
             );
$ob->series(array(array('type' => 'pie','name' => 'Browser share', 'data' => $data)));

return $this->render('SocialProBundle:Admin:pie.html.twig', array(

 'chart' => $ob

 ));


}


}