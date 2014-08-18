<?php

class gerador_admintemplateModel extends \classes\Model\Model{
    private $template = 
'<?php 
class %class%Admin extends %extension%{
    public $model_name = "%model%";
}';
    public function getTemplate($class, $model, $extension = "\classes\Controller\Admin"){
        if($class == "" || $model == "" || $extension == "" ) 
            throw new modelException ("Erro ao gerar template do Admin: Atributos vazios");
        
        return str_replace(
                array("%class%", "%model%", "%extension%"), 
                array($class, $model, $extension), 
                $this->template
        );
    
    }
}