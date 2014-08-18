<?php

class gerador_indextemplateModel extends \classes\Model\Model{
    private $template = 
'<?php
class indexAdmin extends \classes\Controller\Admin{
    public $model_name = "";
}
';
    public function getTemplate(){
        return $this->template;
    }
}