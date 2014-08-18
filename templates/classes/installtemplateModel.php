<?php

class gerador_installtemplateModel extends \classes\Model\Model{
    private $template =       
'<?php
class %class_name%Install extends classes\Classes\InstallPlugin{
    protected $dados = array(
        "pluglabel" => "%title%",
        "isdefault" => "n",
        "system"    => "n",
        "detalhes"  => "",
    );
     public function install(){return true;}
     public function unstall(){return true;}
}
';
    public function getTemplate($arr){
        $arr[] = ucfirst($arr[0]);
        return str_replace(
                array("%class_name%", "%title%"), 
                $arr, 
                $this->template
        );
    
    }
}