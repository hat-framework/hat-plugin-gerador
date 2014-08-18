<?php

class gerador_datatemplateModel extends \classes\Model\Model{
    private $template = 
'<?php 
class %plugin_name%_%class_name%Data extends \classes\Model\DataModel{
    public $dados  = array(%dados%);
}'
    ;
    public function getTemplate($plugin, $name, $tabela, $pkey, $dados){
        if($name == "" || $tabela == "" || $pkey == "" || $dados == "") 
            throw new modelException ("Erro ao gerar template do modelo: Atributos vazios");
        
        $pkey = (is_array($pkey))? $pkey = "array('".implode("','", $pkey)."')" : "'$pkey'";
        return str_replace(
                array("%plugin_name%","%class_name%", "%tabela%", "%pkey%", "%dados%"), 
                array($plugin, $name, $tabela, $pkey, $dados), 
                $this->template
        );
    
    }
}