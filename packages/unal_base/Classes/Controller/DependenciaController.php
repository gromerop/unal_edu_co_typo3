<?php
namespace UNAL\UnalBase\Controller;

/* * *************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2017 Oficina de Medios Digitales - Unimedios <mediosdigitales@unal.edu.co>, Universidad Nacional de Colombia
 *           Giovanni Romero Pérez <gromerop@unal.edu.co>, Universidad Nacional de Colombia
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

/* * *
 *
 * This file is part of the "Extensión base - Universidad Nacional de Colombia" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Oficina de Medios Digitales - Unimedios <mediosdigitales@unal.edu.co>, Universidad Nacional de Colombia
 *           Giovanni Romero Pérez <gromerop@unal.edu.co>, Universidad Nacional de Colombia
 *
 * * */

/**
 * DependenciaController
 */
class DependenciaController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * dependenciaRepository
     *
     * @var \UNAL\UnalBase\Domain\Repository\DependenciaRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $dependenciaRepository = NULL;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $dependencias = $this->dependenciaRepository->findAll();
        $this->view->assign('dependencias', $dependencias);
    }

    /**
     * action show
     *
     * @param \UNAL\UnalBase\Domain\Model\Dependencia $dependencia
     * @return void
     */
    public function showAction(\UNAL\UnalBase\Domain\Model\Dependencia $dependencia)
    {
        $this->view->assign('dependencia', $dependencia);
    }

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {

    }

    /**
     * action create
     *
     * @param \UNAL\UnalBase\Domain\Model\Dependencia $newDependencia
     * @return void
     */
    public function createAction(\UNAL\UnalBase\Domain\Model\Dependencia $newDependencia)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->dependenciaRepository->add($newDependencia);
        $this->redirect('list');
    }

    /**
     * action edit
     *
     * @param \UNAL\UnalBase\Domain\Model\Dependencia $dependencia
     * @TYPO3\CMS\Extbase\Annotation\IgnoreValidation $dependencia
     * @return void
     */
    public function editAction(\UNAL\UnalBase\Domain\Model\Dependencia $dependencia)
    {
        $this->view->assign('dependencia', $dependencia);
    }

    /**
     * action update
     *
     * @param \UNAL\UnalBase\Domain\Model\Dependencia $dependencia
     * @return void
     */
    public function updateAction(\UNAL\UnalBase\Domain\Model\Dependencia $dependencia)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->dependenciaRepository->update($dependencia);
        $this->redirect('list');
    }

    /**
     * action delete
     *
     * @param \UNAL\UnalBase\Domain\Model\Dependencia $dependencia
     * @return void
     */
    public function deleteAction(\UNAL\UnalBase\Domain\Model\Dependencia $dependencia)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->dependenciaRepository->remove($dependencia);
        $this->redirect('list');
    }

    /**
     * action getNivel
     *
     * @return void
     */
    public function getNivelAction()
    {

    }

    /**
     * @param $arbol
     * @param $numeroEspacios
     * @param $dependencia
     */
	public function obtenerArbol(&$arbol, $numeroEspacios, $dependencia)
    {
        if ($dependencia != NULL) {
            $arbol[] = array(
                'dependencia' => $dependencia,
                'numeroEspacios' => $numeroEspacios
            );
            // Se obtienen las dependencias "hijas"
            $dependenciasHijas = $this->dependenciaRepository->findByIdSuperior($dependencia->getUid());
            foreach ($dependenciasHijas as $dependenciaHija) {
                $this->obtenerArbol($arbol, $numeroEspacios + 1, $dependenciaHija);
            }
        }
    }

    public function actualizarJerarquias()
    {
        ini_set('memory_limit', '4096M');
        $dependencias = $this->dependenciaRepository->findAll();
        foreach ($dependencias as $dependencia) {
			 $jerarquia = [$dependencia->getNombre()];
            $dependenciaSuperior = $dependencia;
				do {
					$dependenciaSuperior = $this->dependenciaRepository->findByUid($dependenciaSuperior->getIdSuperior());
                if ($dependenciaSuperior != NULL) {
                    $jerarquia[] = $dependenciaSuperior->getNombre();
                }
            } while ($dependenciaSuperior != NULL);
            $dependencia->setTxtJerarquia(implode(' - ', $jerarquia));
            $this->dependenciaRepository->update($dependencia);
            $persistenceManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
            $persistenceManager->persistAll();
        }
    }

    /**
     * action listarArbol
     *
     * @return void
     */
    public function listarArbolAction()
    {
        //		  $this->actualizarJerarquias();
        $arbol = array();
        $numeroEspacios = 0;
        $dependenciasBase = $this->dependenciaRepository->findByIdSuperior(0);
        foreach ($dependenciasBase as $dependenciaBase) {
            $this->obtenerArbol($arbol, $numeroEspacios, $dependenciaBase);
        }
        $this->view->assign('arbol', $arbol);
    }

    /**
     * @param \UNAL\UnalBase\Domain\Model\Dependencia $dependencia
     */
    function generarTextoNivel(\UNAL\UnalBase\Domain\Model\Dependencia $dependencia)
    {
        $texto = '';
        $conector = '';
        while ($dependencia->getIdSuperior() != 0) {
            $dependencia = $this->dependenciaRepository->findByUid($dependencia->getIdSuperior());
            $texto = $dependencia->getNombre() . $conector . $texto;
            $conector = ' <span class="unalbase_separador_dep"></span> ';
        }
        return $texto;
    }

    /**
     * action buscar
     *
     * @param string $q
     * @param boolean $incluirExcepciones
     * @return string JSON con el resultado de la consulta
     */
    public function buscarAction($q, $incluirExcepciones = FALSE)
    {
        $dependencias = $this->dependenciaRepository->buscar($q, $incluirExcepciones);
        $resultado = array();
        foreach ($dependencias as $dependencia) {
            $nombreDependencia = $dependencia->getNombre() . '[' . $this->generarTextoNivel($dependencia) . ']';
            $uid = $dependencia->getUid();
            $resultado[] = array(
                'label' => $nombreDependencia,
                'value' => $uid
            );
        }
        return json_encode($resultado);
    }

    /**
     * action buscarPorId
     * Obtiene una dependencia con el Id dado. Si el id no es válido, se retornará un array vacío.
     *
     * @param string $q
     * @return string JSON con el resultado de la consulta
     */
    public function buscarPorIdAction($q)
    {
        $resultado = array();
        $dependencia = $this->dependenciaRepository->findByUid($q);
        if ($dependencia instanceof \UNAL\UnalBase\Domain\Model\Dependencia) {
            $nombreDependencia = $dependencia->getNombre() . '[' . $this->generarTextoNivel($dependencia) . ']';
            $uid = $dependencia->getUid();
            $resultado[] = array(
                'label' => $nombreDependencia,
                'value' => $uid
            );
        }
        return json_encode($resultado);
    }
}
