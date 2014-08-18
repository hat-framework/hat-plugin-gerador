<?php 
class gerador_componenteModel extends \classes\Model\Model{
    public $tabela = "gerador_componente";
    public $pkey   = "cod_componente";
    public $dados  = array(
        'cod_componente' => array(
            'name'    => "Dados",
            'pkey'    => true,
            'ai'      => true,
            'type'    => 'int',
            'grid'    => true,
            'notnull' => true
         ),
        
        'view' => array(
            'name'    => 'Nome',
            'type'    => 'varchar',
            'size'    => '127', 
            //'search'  => true,
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