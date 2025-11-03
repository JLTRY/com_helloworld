<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
namespace JohnSmith\Component\HelloWorld\Administrator\View\Helloworlds;
defined('_JEXEC') or die('Restricted access');

use JohnSmith\Component\HelloWorld\Administrator\Helper\HelloWorldHelper;
use Joomla\CMS\Log\Log;
use Joomla\CMS\MVC\Factory\MVCFactory;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Document\Document;

/**
 * HelloWorlds View
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
		
		// Get application
		$app = Factory::getApplication();
		$context = "helloworld.list.admin.helloworld";
		// Get data from the model
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->state		= $this->get('State');
		$this->filter_order	= $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'greeting', 'cmd');
		$this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
		$this->filterForm    	= $this->get('FilterForm');
		$this->activeFilters 	= $this->get('ActiveFilters');

		// What Access Permissions does this user have? What can (s)he do?
		$this->canDo = HelloWorldHelper::getActions();

		// Check for errors.
		if (is_array($errors = $this->get('Errors'))&& count($errors))
		{
			Factory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');
			return false;
		}

		// Set the submenu
		HelloWorldHelper::addSubmenu('helloworlds');

		// Set the toolbar and number of found items
		$this->addToolBar();

		// Display the template
		parent::display($tpl);

		// Set the document
		$document = Factory::getDocument();
		$document->setTitle(Text::_('COM_HELLOWORLD_ADMINISTRATION'));
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolBar()
	{
		$title = Text::_('COM_HELLOWORLD_MANAGER_HELLOWORLDS');

		if ($this->pagination->total)
		{
			$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		}

		ToolbarHelper::title($title, 'helloworld');

		if ($this->canDo->get('core.create')) 
		{
			ToolbarHelper::addNew('helloworld.add', 'JTOOLBAR_NEW');
		}
		if ($this->canDo->get('core.edit')) 
		{
			ToolbarHelper::editList('helloworld.edit', 'JTOOLBAR_EDIT');
		}
		if ($this->canDo->get('core.delete')) 
		{
			ToolbarHelper::deleteList('', 'helloworlds.delete', 'JTOOLBAR_DELETE');
		}
		if ($this->canDo->get('core.admin')) 
		{
			ToolbarHelper::divider();
			ToolbarHelper::preferences('com_helloworld');
		}
	}	
}