<?php 
class gerador_gadgetModel extends \classes\Model\Model{
    public $tabela = "gerador_gadget";
    public $pkey   = "cod_gadget";
    public $dados  = array(
        'cod_gadget' => array(
            'name'    => "Gadget",
            'pkey'    => true,
            'ai'      => true,
            'type'    => 'int',
            'grid'    => true,
            'notnull' => true
         ),
        
        'regiao' => array(
            'name'      => 'Região',
            'type'      => 'enum',
            'default'   => '',
            'options'   => array(
                'banner'   => 'Banner',
                'direota'  => 'Direita',
                'esquerda' => 'Esquerda',
                'centro'   => 'Centro',
                'rodape'   => 'Rodapé',
            ),
            'notnull'   => true
       	 ),
        
        'recurso' => array(
            'name'    => 'Recurso',
            'type'    => 'varchar',
            'size'    => '127', 
            'grid'    => true,
            'notnull' => true
       	),
        
        'jsplugin' => array(
            'name'    => 'Jsplugin',
            'type'    => 'varchar',
            'size'    => '127', 
            'grid'    => true,
            'notnull' => true
       	),
        
        'cod_widget' => array(
            'name'      => 'Dados',
            'type' 	=> 'int',
            'notnull'   => true,
            'fkey'      => array(
                'model' 	=> 'gerador/widget', 
                'keys'          => array('cod_widget', 'wnome'),
                'cardinalidade' => '1n'//nn 1n 11
            )
         )
        
    );
}
?>