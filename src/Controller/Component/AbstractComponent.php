<?php

namespace App\Controller\Component;

use Cake\Controller\Component;

class AbstractComponent extends Component {

    /**
     * Constructor
     *
     * @param \Cake\Controller\ComponentRegistry $registry A ComponentRegistry this component can use to lazy load its components
     * @param array $config Array of configuration settings.
     */
    public function __construct(\Cake\Controller\ComponentRegistry $registry, array $config = [])
    {
        $this->_registry = $registry;
        $controller = $registry->getController();
        
        foreach($controller->entities as $entityName){
            $this->{strtolower($entityName)} = $controller->{strtolower($entityName)};
        }

        if ($controller) {
            $this->request =& $controller->request;
            $this->response =& $controller->response;
        }

        $this->config($config);

        if (!empty($this->components)) {
            $this->_componentMap = $registry->normalizeArray($this->components);
        }
        $this->initialize($config);
    }

}
