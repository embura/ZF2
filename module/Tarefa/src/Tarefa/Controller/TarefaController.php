<?php
/**
 * Created by PhpStorm.
 * User: jefferson
 * Date: 24/06/2015
 * Time: 14:33
 */

namespace Tarefa\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;


class TarefaController extends  AbstractActionController{

    public function indexAction()
    {
        $texto = "Eu fui definido no controller, mas vou aparecer na view";

        return new ViewModel(array('exemplo' => $texto));
    }

    public function lista(){

    }
}