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
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		foreach ($this->settings['manifests'] as $key => $manifest) {
			$this->settings['manifests'][$key] = t3lib_div::getFileAbsFileName($manifest);
		}

		$packager = t3lib_div::makeInstance('Tx_MootoolsEssentials_Domain_Model_Packager');
		$packager->addManifests($this->settings['manifests']);
		$behaviors = $packager->getBehaviors();

		$this->view->assign('behaviors', $behaviors);
		//$this->view->assign('delegator', $delegators);
	}

	/**
	 * Before every ActionMethod create a proper template so you can use the pageRenderer
	 * After every ActionMethod call the Loader to add the needed MooTools files
	 *
	 * @return void
	 */
	protected function callActionMethod() {
		$this->template = t3lib_div::makeInstance('template');
		$this->template->endJS = false;
		$this->template->getPageRenderer();

		$GLOBALS['SOBE'] = new stdClass();
		$GLOBALS['SOBE']->doc = $this->template;

		parent::callActionMethod();

		// calling it after parent::callActionMethod won't allow for addJsFooter Stuff; before only allow addJsFooter Stuff :/
		// so let's call it after, so you can use addCssFile(...)
		$pageHeader = $this->template->startpage('title', false);

		// startpage does reset inlineFooterJs :/ so we have to do the loading later
		$loader = t3lib_div::makeInstance('Tx_MootoolsEssentials_Controller_LoadController');
		$loader->load($this->settings);

		// $pageEnd = $this->template->endPage(); // don't work as it usese the resetted inlineFooterJs stuff from startpage
		$pageEnd = $this->template->getPageRenderer()->render(t3lib_PageRenderer::PART_FOOTER);

		$this->response->setContent($pageHeader . $this->response->getContent() . $pageEnd);
	}

}
?>