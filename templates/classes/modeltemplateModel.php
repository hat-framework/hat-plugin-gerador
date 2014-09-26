<?php

class gerador_modeltemplateModel extends \classes\Model\Model{
    private $template = 
'<?php 
class %plugin_name%_%class_name%Model extends \classes\Model\Model{
    public $tabela = "%tabela%";
    public $pkey   = %pkey%;
}
'
    ;
    public function getTemplate($plugin, $name, $tabela, $pkey, $dados, $extension = "\classes\Model\Model"){
        if($name == "" || $tabela == "" || $pkey == "" || $dados == ""|| $extension == "" ) {
            throw new \classes\Exceptions\modelException ("Erro ao gerar template do modelo: Atributos vazios ($name - $tabela - $pkey - $extension )");
        }
        
        $pkey = (is_array($pkey))? $pkey = "array('".implode("','", $pkey)."')" : "'$pkey'";
        return str_replace(
                array("%plugin_name%","%class_name%", "%tabela%", "%pkey%", "%dados%", "%extension%"), 
                array($plugin, $name, $tabela, $pkey, $dados, $extension), 
                $this->template
        );
    
    }
}
