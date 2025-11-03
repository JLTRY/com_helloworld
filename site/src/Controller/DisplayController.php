<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2020 John Smith. All rights reserved.
 * @license     GNU General Public License version 3; see LICENSE
 */

namespace JohnSmith\Component\HelloWorld\Site\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\MVC\Controller\BaseController;



/**
 * Default Controller of HelloWorld component
 *
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 */
class DisplayController extends BaseController {


    public function display($cachable = false, $urlparams = false)
    {
        $input = $this->app->getInput();
        // Set the default view (if not specified)
        $input->set('view', $input->getCmd('view', 'Helloworld'));

        // Call parent to display
        parent::display($cachable);
    }
}