<?php

class gerador_loadertemplateModel extends \classes\Model\Model{
    private $template = 
'<?php
class %class_name%Loader extends classes\Classes\PluginLoader{
    public function setCommonVars(){}
    public function setAdminVars(){}
}
';
    public function getTemplate($arr){
        return str_replace(
                array("%class_name%"), 
                $arr, 
                $this->template
        );
    
    }
}