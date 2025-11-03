<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
namespace JohnSmith\Component\HelloWorld\Administrator\View\Helloworld;
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
 * HelloWorld View
 *
 * @since  0.0.1
 */
class HtmlView extends BaseHtmlView
{
	protected $form;
	protected $item;
	protected $script;
	protected $canDo;

	/**
	 * Display the Hello World view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	public function display($tpl = null)
	{
		// Get the Data
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->script = $this->get('Script');

		// What Access Permissions does this user have? What can (s)he do?
		$this->canDo = HelloWorldHelper::getActions($this->item->id);

		// Check for errors.
		if (is_array($errors = $this->get('Errors'))&& count($errors))
		{
            return Factory::getApplication()->enqueueMessage(implode('<br />', $errors), 'error');
		}

		// Set the toolbar
		$this->addToolBar();

		// Display the template
		parent::display($tpl);

		// Set the document
		$isNew = ($this->item->id == 0);
		$document = Factory::getDocument();
		$document->setTitle($isNew ? Text::_('COM_HELLOWORLD_HELLOWORLD_CREATING')
		                           : Text::_('COM_HELLOWORLD_HELLOWORLD_EDITING'));
		$document->addScript(Uri::root() . $this->script);
		$document->addScript(Uri::root() . "/administrator/components/com_helloworld"
		                                  . "/src/View/HelloWorld/submitbutton.js");
		Text::script('COM_HELLOWORLD_HELLOWORLD_ERROR_UNACCEPTABLE');
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
		$input = Factory::getApplication()->input;

		// Hide Joomla Administrator Main menu
		$input->set('hidemainmenu', true);

		$isNew = ($this->item->id == 0);

		ToolBarHelper::title($isNew ? Text::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_NEW')
		                             : Text::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_EDIT'), 'helloworld');
		// Build the actions for new and existing records.
		if ($isNew)
		{
			// For new records, check the create permission.
			if ($this->canDo->get('core.create')) 
			{
				ToolBarHelper::apply('helloworld.apply', 'JTOOLBAR_APPLY');
				ToolBarHelper::save('helloworld.save', 'JTOOLBAR_SAVE');
				ToolBarHelper::custom('helloworld.save2new', 'save-new.png', 'save-new_f2.png',
				                       'JTOOLBAR_SAVE_AND_NEW', false);
			}
			ToolBarHelper::cancel('helloworld.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			if ($this->canDo->get('core.edit'))
			{
				// We can save the new record
				ToolBarHelper::apply('helloworld.apply', 'JTOOLBAR_APPLY');
				ToolBarHelper::save('helloworld.save', 'JTOOLBAR_SAVE');
 
				// We can save this record, but check the create permission to see
				// if we can return to make a new one.
				if ($this->canDo->get('core.create')) 
				{
					ToolBarHelper::custom('helloworld.save2new', 'save-new.png', 'save-new_f2.png',
					                       'JTOOLBAR_SAVE_AND_NEW', false);
				}
			}
			if ($this->canDo->get('core.create')) 
			{
				ToolBarHelper::custom('helloworld.save2copy', 'save-copy.png', 'save-copy_f2.png',
				                       'JTOOLBAR_SAVE_AS_COPY', false);
			}
			ToolBarHelper::cancel('helloworld.cancel', 'JTOOLBAR_CLOSE');
		}
	}
	
}
