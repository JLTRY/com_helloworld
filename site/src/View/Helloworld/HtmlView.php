<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace JohnSmith\Component\HelloWorld\Site\View\Helloworld;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;

/**
 * HTML View class for the HelloWorld Component
 *
 * @since  0.0.1
 */
class HtmlView extends BaseHtmlView
{
	/**
	 * Display the Hello World view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{
		// Assign data to the view
		$this->item = $this->get('Item');

		// Check for errors.
		if (is_array($errors = $this->get('Errors'))&& count($errors))
		{
            return Factory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');
		}

		// Display the view
		parent::display($tpl);
	}
}
