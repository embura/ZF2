<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Composer\Console;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use \Application\Model\Funcionario;




class IndexController extends AbstractActionController
{
    private  $em  ;

    public function __construct(){
       //$this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        //$this->em = self::getServiceLocator()->get('Doctrine\ORM\EntityManager');
    }


    public function indexAction() {
        $request = $this->getRequest();
        $result = array();
        if($request->isPost()) {
            try{
                $nome = $request->getPost("nome");
                $cpf = $request->getPost("cpf");
                $salario = $request->getPost("salario");

                $funcionario = new \Application\Model\Funcionario();
                $funcionario->setNome($nome);
                $funcionario->setCpf($cpf);
                $funcionario->setSalario($salario);

                $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager'); // Melhorar
                $em->persist($funcionario);
                $em->flush();

                $result["resp"] = $nome. ", enviado corretamente!";
            } catch (Exception $e){
                print($e);
            }
        }
        return new ViewModel($result);
    }

    public function listaAction() {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $lista = $em->getRepository('Application\Model\Funcionario')->findAll();


        return new ViewModel(array('lista' => $lista));
    }

    public function excluirAction() {
        $id = $this->params()->fromRoute("id", 0);
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $funcionario = $em->find("Application\Model\Funcionario", $id);
        $em->remove($funcionario);
        $em->flush();
        return $this->redirect()->toRoute(
            'application/default', array(
                'controller' => 'index',
                'action' => 'lista')
        );
    }

    public function editarAction() {
        $id = $this->params()->fromRoute("id", 0);
        $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
        $funcionario = $em->find("Application\Model\Funcionario", $id);
        $request = $this->getRequest();
        $controller = array('controller' => 'index', 'action' => 'lista');

        if($request->isPost()) {
            try{
                $nome = $request->getPost("nome");
                $cpf = $request->getPost("cpf");
                $salario = $request->getPost("salario");
                $funcionario->setNome($nome);
                $funcionario->setCpf($cpf);
                $funcionario->setSalario($salario);
                $em = $this->getServiceLocator()->get("Doctrine\ORM\EntityManager");
                $em->merge($funcionario);
                $em->flush();
            } catch (Exception $e){
                print($e);
            }
            return $this->redirect()->toRoute('application/default', $controller);
        }
        $arrReturn = array('funcionario' => $funcionario,'c' => $controller);

        return new ViewModel($arrReturn);
    }










}
