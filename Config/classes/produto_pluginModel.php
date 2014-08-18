<?php
class gerador_produto_pluginModel extends \classes\Model\Model{
    public $tabela = "gerador_plugin_produto";
    public $pkey   = array("cod_produto", "cod_plugin");
    
    public $dados  = array(
        
        'cod_plugin' => array(
            'name'    => "Plugin",
            'pkey'    => true,
            'type'    => 'int',
            'notnull' => true,
            'fkey'      => array(
                'model' 	=> 'gerador/gplugin', 
                'keys'          => array('cod_plugin', 'plugnome'),
                'cardinalidade' => '1n'//nn 1n 11
            )
        ),
        
        'cod_produto' => array(
            'name'      => 'Produto',
            'pkey'    => true,
            'type' 	=> 'int',
            'notnull' => true,
            'fkey'      => array(
                'model' 	=> 'gerador/gproduto', 
                'keys'          => array('cod_produto', 'pnome'),
                'cardinalidade' => '1n'//nn 1n 11
            )
         )
        
    );
}
?>