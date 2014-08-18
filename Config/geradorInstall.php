<?php

class geradorInstall extends classes\Classes\InstallPlugin{
    
    protected $dados = array(
        'pluglabel' => 'Gerador de Código',
        'isdefault' => 'n',
        'system'    => 'n',
    );
    
    public function install(){
        return true;
    }
    
    public function unstall(){
        return true;
    }
}