<?php

class converterController extends \classes\Controller\Admin{
    
    public function index(){
        if(!empty ($_POST)){
            //$this->registerVar('parsed', $this->model->InsertDesign($_POST));
            $this->model->InsertDesign($_POST);
            $this->setVars($this->model->getMessages());
        }
        $this->genTags("Xml2File Converter");
        $form = $this->model->getForm();
        $this->registerVar('dados', $form);
        $this->display(LINK."/index");
    }
    
}