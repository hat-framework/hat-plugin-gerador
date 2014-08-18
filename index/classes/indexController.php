<?php
class indexController extends \classes\Controller\Controller{
    public $model_name = "";
    public function index(){
        Redirect('gerador/converter');
    }
}
?>
