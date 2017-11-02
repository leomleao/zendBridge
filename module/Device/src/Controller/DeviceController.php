<?php

namespace Device\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DeviceController extends AbstractActionController
{	

	// Add this property:
    private $table;

    // Add this constructor:
    public function __construct(DeviceTable $table)
    {
        $this->table = $table;
    }


    public function indexAction()
    {
    	return new ViewModel([
            'devices' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }
}