<?php
class indexController extends \classes\Controller\Controller{
    public $model_name = "";
    public function index(){
        $this->registerVar('url', URL. "/vendor/hatframework/basehat/sqldesigner");
        $this->display(LINK . "/index");
        //Redirect('gerador/converter');
    }
}