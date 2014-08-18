<?php

class gerador_componenttemplateModel extends \classes\Model\Model{
    private $template = 
'<?php
class %class%Component extends %extends%{

}';
    public function getTemplate($class, $extension = "classes\Component\Component"){
        if($class == "" || $extension == "" ) 
            throw new modelException ("Erro ao gerar template do controller: Atributos vazios");
        
        return str_replace(
                array("%class%", "%extends%"), 
                array($class, $extension), 
                $this->template
        );
    
    }
}