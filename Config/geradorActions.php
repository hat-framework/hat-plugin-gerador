<?php 
use classes\Classes\Actions;
class geradorActions extends Actions{
    protected $permissions = array(
        "gerador" => array(
            "nome"      => "gerador",
            "label"     => "gerador",
            "descricao" => "Permite acesso ao plugin",
            "default"   => "s",
        ),
    );
    
    protected $actions = array(
        "gerador/converter/index" => array(
            "label" => "Gerador", "publico" => "s", "default_yes" => "s","default_no" => "s",
            "permission" => "gerador",
         ),
    );
    
}