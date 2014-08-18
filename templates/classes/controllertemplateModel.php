<?php

class gerador_controllertemplateModel extends \classes\Model\Model{
    private $template = 
'<?php 
     use classes\Controller\CController;
class %class%Controller extends %extension%{
    public $model_name = %model%;
    
    %method%
}';
    public function getTemplate($class, $model = "", $extension = "\classes\Controller\CController"){
        if($class == "" || $extension == "" ) 
            throw new modelException ("Erro ao gerar template do controller: Atributos vazios");
        
        $method = "";
        $model = ($model == "")? strstr($class, "index")?"''":"LINK":"'$model'";
        if($model == "''") {
            $extension = "\classes\Controller\Controller";
            $method    = '
            public function index(){
                $this->display("");
            }';
        }
        return str_replace(
                array("%class%", "%model%", "%extension%", "%method%"), 
                array($class, $model, $extension, $method), 
                $this->template
        );
    
    }
}
