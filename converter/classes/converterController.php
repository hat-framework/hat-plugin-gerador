<?php

class converterController extends \classes\Controller\Admin{
    
    public function index(){
        if(!empty ($_POST)){
            $this->LoadResource('database', 'db');
            $this->db->executeQuery("truncate gerador_gadget;");
            $this->db->executeQuery("truncate gerador_componente;");
            $this->db->executeQuery("truncate gerador_gadget;");
            $this->db->executeQuery("truncate gerador_gdados;");
            $this->db->executeQuery("truncate gerador_plugin;");
            $this->db->executeQuery("truncate gerador_produto;");
            $this->db->executeQuery("truncate gerador_widget;");
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