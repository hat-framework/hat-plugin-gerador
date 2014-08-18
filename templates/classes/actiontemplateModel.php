<?php

use classes\Classes\Actions;
class gerador_actiontemplateModel extends \classes\Model\Model{
    private $template = 
'<?php 
use classes\Classes\Actions;   
class %plugin%Actions extends Actions{
    protected $permissions = array(
        "%plugin%/public" => array(
            "nome"      => "%plugin%/public",
            "label"     => "Acesso ao %plugin%",
            "descricao" => "Acesso público ao plugin %plugin%",
            "default"   => "s",
        ),
         "%plugin%/admin" => array(
            "nome"      => "%plugin%/admin",
            "label"     => "Administrar %plugin%",
            "descricao" => "Permite gerenciar (adicionar, visualizar, editar e apagar) os dados do plugin %plugin%",
            "default"   => "n",
        ),
        
    );
    
    protected $actions = array( 
        "%plugin%/index/index" => array(
            "label" => "%plugin%", "publico" => "n", "default_yes" => "s","default_no" => "n",
            "permission" => "%plugin%/admin",
            "menu" => array(%acoes%),
            "breadscrumb" => array("%plugin%/index/index", )
        ),
        %conteudo%
    );
    
}
';
    private static $permission = "";
    private static $action     = "";
    public function getTemplate($array){
        $plugin  = array_shift($array);
        $widgets = array_shift($array);;
        
        $plug = str_replace("-", "_",GetPlainName($plugin));
        
        $replace = "";
        foreach($widgets as $wid) $replace .= "'$plug/".$wid['wnome']."/index',";
        return str_replace(
                array('%plugin%', '%acoes%', '%conteudo%'), 
                array($plug, $replace, gerador_actiontemplateModel::$action), 
                $this->template
        );
    }
    
    public function setTempTemplate($arr){
        if(empty($arr)) return;
        gerador_actiontemplateModel::$action .= str_replace(
                array('%name%', '%model%', '%plugin%'),  $arr, $this->template_action
        );
        
        gerador_actiontemplateModel::$permission .= str_replace(
                array('%name%', '%model%', '%plugin%'),  $arr, $this->permission_action
        );
    }
    
    private $template_action = "
        
        '%model%/index' => array(
            'label' => '%name%', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => '%plugin%/admin',
            'menu' => array('Página Principal' => '%plugin%/index/index', '%model%/formulario')
        ),
        
        '%model%/formulario' => array(
            'label' => 'Criar %name%', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => '%plugin%/admin',
            'menu' => array('Voltar' => '%model%/index')
        ),
        
        '%model%/show' => array(
            'label' => 'Visualizar %name%', 'publico' => 'n', 'default_yes' => 's','default_no' => 'n',
            'permission' => '%plugin%/admin', 'needcod' => true,
            'menu' => array('%model%/index', 'Ações' => array('Editar' => '%model%/edit', 'Excluir' => '%model%/apagar'))
        ),
        
        '%model%/edit' => array(
            'label' => 'Editar %name%', 'publico' => 'n', 'default_no' => 's','default_no' => 'n', 
            'permission' => '%plugin%/admin', 'needcod' => true,
            'menu' => array('%model%/index', 'Voltar para %name%' => '%model%/show')
        ),

        '%model%/apagar' => array(
            'label' => 'Excluir %name%', 'publico' => 'n', 'default_no' => 's','default_no' => 'n',
            'permission' => '%plugin%/admin', 'needcod' => true,
            'menu' => array()
        ),

    ";
    
}

?>
