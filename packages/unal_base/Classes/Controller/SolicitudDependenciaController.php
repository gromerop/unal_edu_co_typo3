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

/***
 *
 * This file is part of the "Extensión base - Universidad Nacional de Colombia" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Oficina de Medios Digitales - Unimedios <mediosdigitales@unal.edu.co>, Universidad Nacional de Colombia
 *           Giovanni Romero Pérez <gromerop@unal.edu.co>, Universidad Nacional de Colombia
 *
 ***/

/**
 * SolicitudDependenciaController
 */
class SolicitudDependenciaController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    /**
     * solicitudDependenciaRepository
     *
     * @var \UNAL\UnalBase\Domain\Repository\SolicitudDependenciaRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $solicitudDependenciaRepository = NULL;

    /**
     * dependenciaRepository
     *
     * @var \UNAL\UnalBase\Domain\Repository\DependenciaRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $dependenciaRepository = NULL;

    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $persistenceManager = null;

    /**
     * usuarioRepository
     *
     * @var \Causal\IgLdapSsoAuth\Domain\Repository\Typo3UserRepository
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $usuarioRepository = NULL;

    /**
     * objectManager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     * @TYPO3\CMS\Extbase\Annotation\Inject
     */
    protected $objectManager = NULL;

    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        if (isset($GLOBALS['TSFE']->fe_user->user['uid'])) {
            $this->view->assign('solicitante', $GLOBALS['TSFE']->fe_user->user['uid']);
        } else {
            $this->logoff();
        }
    }

    /**
     * action create
     *
     * @param \UNAL\UnalBase\Domain\Model\SolicitudDependencia $newSolicitudDependencia
     * @return void
     */
    public function createAction(\UNAL\UnalBase\Domain\Model\SolicitudDependencia $newSolicitudDependencia)
    {
        if (isset($GLOBALS['TSFE']->fe_user->user['uid'])) {
            $solicitanteLogin = $GLOBALS['TSFE']->fe_user->user['uid'];
            if ($solicitanteLogin == $newSolicitudDependencia->getSolicitante()) {
                $usuario = $this->usuarioRepository->fetch('fe_users', $solicitanteLogin)[0];
                $dependenciaSuperior = $this->dependenciaRepository->findByUid($newSolicitudDependencia->getIdSuperior());
                // Se guarda la solicitud en el repositorio
                $this->solicitudDependenciaRepository->add($newSolicitudDependencia);
                $this->persistenceManager->persistAll();
                // Se envía un mensaje de correo con los detalles de la solicitud
                $emailEnviado = \UNAL\UnalBase\Utility\TemplateEmail::send(
                    array($usuario['email'] => $usuario['name']), array(),
                    array('mediosdigitales@unal.edu.co' => 'Oficina de Medios Digitales'),
                    array(),
                    array(),
                    'Adición de dependencia - Solicitud recibida (No. ' . $newSolicitudDependencia->getUid() . ')',
                    'EXT:unal_base/Resources/Private/Templates/Email/SolicitudDependencia.html',
                    array(
                        'solicitud' => $newSolicitudDependencia,
                        'usuario' => $usuario,
                        'dependenciaSuperior' => $dependenciaSuperior
                    ),
                    array()
                );
                if ($emailEnviado) {
                    $this->addFlashMessage('Su solicitud ha sido recibida. Se ha enviado un mensaje a su cuenta de correo.', 'Gracias', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
                } else {
                    $this->addFlashMessage('No se pudo enviar el mensaje de confirmación.', 'Error', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                }
            } else {
                $this->addFlashMessage('No coincide el id ingresado con el usuario que inició sesión.', 'Error', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
                $this->redirect('new');
            }
        } else {
            $this->addFlashMessage('No se ha iniciado sesión.', 'Error', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        }
    }

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $solicitudDependencias = $this->solicitudDependenciaRepository->findAll();
        $this->view->assign('solicitudDependencias', $solicitudDependencias);
    }

    /**
     * action responder
     *
     * @param \UNAL\UnalBase\Domain\Model\SolicitudDependencia $solicitudDependencia
     * @param int $aprobar
     * @return void
     */
    public function responderAction(\UNAL\UnalBase\Domain\Model\SolicitudDependencia $solicitudDependencia, $aprobar)
    {
        $ahora = $this->objectManager->get('DateTime');
        $solicitudDependencia->setFechaRespuesta($ahora);
        $dependenciaSuperior = $this->dependenciaRepository->findByUid($solicitudDependencia->getIdSuperior());
        $usuario = $this->usuarioRepository->fetch('fe_users', $solicitudDependencia->getSolicitante())[0];
        if ($aprobar == 1) {
            $dependencia = $this->objectManager->get('UNAL\\UnalBase\\Domain\\Model\\Dependencia');
            $dependencia->setNombre($solicitudDependencia->getNombreDependencia());
            $dependencia->setIdSuperior($solicitudDependencia->getIdSuperior());
            $this->dependenciaRepository->add($dependencia);
            $this->persistenceManager->persistAll();
            $solicitudDependencia->setIdDependenciaCreada($dependencia->getUid());
        }
        // Se envía un mensaje de correo al usuario
        $emailEnviado = \UNAL\UnalBase\Utility\TemplateEmail::send(
            array($usuario['email'] => $usuario['name']), array(),
            array('mediosdigitales@unal.edu.co' => 'Oficina de Medios Digitales'),
            array(),
            array(),
            'Respuesta a su solicitud de adición de dependencia (No. ' . $solicitudDependencia->getUid() . ')',
            'EXT:unal_base/Resources/Private/Templates/Email/RespuestaSolicitudDependencia.html',
            array(
                'solicitud' => $solicitudDependencia,
                'usuario' => $usuario,
                'dependenciaSuperior' => $dependenciaSuperior
            ),
            array()
        );
        $this->solicitudDependenciaRepository->update($solicitudDependencia);
        if ($emailEnviado) {
            $this->addFlashMessage('Se ha enviado la respuesta al solicitante.', 'Respuesta enviada', \TYPO3\CMS\Core\Messaging\AbstractMessage::OK);
        } else {
            $this->addFlashMessage('No se pudo enviar el mensaje de respuesta.', 'Error', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        }
        $this->redirect('list');
    }
}
