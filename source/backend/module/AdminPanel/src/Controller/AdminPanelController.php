<?php

namespace AdminPanel\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AdminPanelController extends AbstractActionController
{
    public function __construct()
    {
    }

    public function indexAction()
    {
        return new ViewModel();
    }
}
