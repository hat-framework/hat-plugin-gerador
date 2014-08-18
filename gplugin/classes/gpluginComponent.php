<?php

class gpluginComponent extends classes\Component\Component{
    
    public function gerar($model, $item){
        $dados = array(
           'plugin' => array(
                'name'  => 'Plugin',
                'type' 	=> 'int',
                'fkey'      => array(
                    'model' 	=> 'gerador/gplugin', 
                    'keys'          => array('cod_plugin', 'plugnome'),
                    'cardinalidade' => '1n'//nn 1n 11
                )
           ),
        );

        $this->LoadResource("formulario", 'form');
        $this->form->NewForm($dados, $_POST, array(), false);
    }
    
}

?>
