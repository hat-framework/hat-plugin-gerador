<?php

class actionsController extends \classes\Controller\Controller{
    public function index() {
        $this->LoadModel('gerador/actions', 'act');
        $this->act->readXml(__DIR__ . "/diagrama.xml");
    }
}