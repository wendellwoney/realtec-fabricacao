<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Insumo\Controller;

use Doctrine\ORM\EntityManager;
use Entity\Insumo;
use Insumo\Model\InsumoModelo;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\Date;
use Zend\View\Model\ViewModel;

class EstoqueController extends AbstractActionController
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $view = new ViewModel();
        $insumoModel = new InsumoModelo($this->entityManager);

        if($this->params()->fromRoute('id')) {
            try{
                $insumoModel->delete($this->params()->fromRoute('id'));
                $view->setVariable('msgs', 'Insumo removido!');
            } catch (\Exception $e) {
                $view->setVariable('msge', $e->getMessage());
            }
        }

        $view->setVariable('insumos', $insumoModel->getList());
        return $view;
    }

    public function cadastroAction()
    {
        $view = new ViewModel();
        if ($this->getRequest()->isPost()) {
            $insumo = new Insumo();
            $insumo->setIdInsumo(0);
            $insumo->setCodigo($this->params()->fromPost('codigo'));
            $insumo->setNome($this->params()->fromPost('nome'));
            $insumo->setUnidadeMedida($this->params()->fromPost('unidade_medida'));
            $insumo->setAlertaValorMinimo($this->params()->fromPost('estoque'));
            $insumo->setObservacao($this->params()->fromPost('observacao'));
            $insumo->setAtivo('1');
            $insumo->setDataCadastro(new \DateTime('now'));

            try{
                $insumoModelo = new InsumoModelo($this->entityManager);
                $insumoModelo->create($insumo);
                $view->setVariable('msgs', 'Insumo cadastrado!');
            } catch (\Exception $e) {
                $view->setVariable('msge', $e->getMessage());
            }
        }
        return $view;
    }

    public function editarAction()
    {
        $insumoModelo = new InsumoModelo($this->entityManager);
        $view = new ViewModel();
        if ($this->getRequest()->isPost()) {
            $insumo = new Insumo();
            $insumo->setIdInsumo($this->params()->fromPost('id'));
            $insumo->setCodigo($this->params()->fromPost('codigo'));
            $insumo->setNome($this->params()->fromPost('nome'));
            $insumo->setUnidadeMedida($this->params()->fromPost('unidade_medida'));
            $insumo->setAlertaValorMinimo($this->params()->fromPost('estoque'));
            $insumo->setObservacao($this->params()->fromPost('observacao'));
            $insumo->setAtivo('1');
            $insumo->setDataCadastro(new \DateTime('now'));

            try{
                $insumoModelo->update($insumo);
                $view->setVariable('msgs', 'Insumo editado!');
            } catch (\Exception $e) {
                $view->setVariable('msge', $e->getMessage());
            }
        }

        $view->setVariable('insumo', $insumoModelo->get($this->params()->fromRoute('idinsumo')));
        return $view;
    }
}
