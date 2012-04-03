<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Thomas Allmer <thomas.allmer@webteam.at>, WEBTEAM GmbH
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
 ***************************************************************/

/**
 *
 *
 * @package mootools_essentials
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_MootoolsEssentials_Controller_BehaviorController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var t3lib_PageRenderer
	 */
	protected $pageRenderer;

	/**
	 * @var integer
	 */
	protected $pageId;

	/**
	 * Initializes the controller before invoking an action method.
	 *
	 * @return void
	 */
	protected function initializeAction() {
		// @todo Evaluate how the intval() call can be used with Extbase validators/filters
		$this->pageId = intval(t3lib_div::_GP('id'));

//		$this->pageRenderer->addInlineLanguageLabelFile('EXT:workspaces/Resources/Private/Language/locallang.xml');
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
//		$packager = t3lib_div::makeInstance('Tx_MootoolsEssentials_Domain_Model_Packager');
//		$behaviors = $packager->getBehaviors();
//		var_dump($behaviors);

		$this->view->assign('behaviors', $behaviors);
		//$this->view->assign('delegator', $delegators);
		$output = $this->view->render();

		foreach ($this->settings['manifests'] as $key => $manifest) {
			$this->settings['manifests'][$key] = t3lib_div::getFileAbsFileName($manifest);
		}
		$packager = t3lib_div::makeInstance('Tx_MootoolsEssentials_Domain_Model_Packager');
		$packager->addManifests($this->settings['manifests']);

		$files = $packager->getCompleteFiles();
		var_dump($files);

		return $output;
	}

	/**
	 * Processes a general request. The result can be returned by altering the given response.
	 *
	 * @param Tx_Extbase_MVC_RequestInterface $request The request object
	 * @param Tx_Extbase_MVC_ResponseInterface $response The response, modified by this handler
	 * @throws Tx_Extbase_MVC_Exception_UnsupportedRequestType if the controller doesn't support the current request type
	 * @return void
	 */
	public function processRequest(Tx_Extbase_MVC_RequestInterface $request, Tx_Extbase_MVC_ResponseInterface $response) {
		$this->template = t3lib_div::makeInstance('template');
		$this->template->endJS = false;
		$this->pageRenderer = $this->template->getPageRenderer();

		$GLOBALS['SOBE'] = new stdClass();
		$GLOBALS['SOBE']->doc = $this->template;

		parent::processRequest($request, $response);

		$pageHeader = $this->template->startpage('title', false);
		$pageEnd = $this->template->endPage();
		$response->setContent($pageHeader . $response->getContent() . $pageEnd);
	}

}
?>