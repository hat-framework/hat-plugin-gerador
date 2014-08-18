<?php

class gprodutoComponent extends classes\Component\Component{
    
    public function gerarProduto($model, $item){
        $dados = array(
           'produto' => array(
                'name'  => 'Produto',
                'type' 	=> 'int',
                'fkey'      => array(
                    'model' 	=> 'gerador/gproduto', 
                    'keys'          => array('cod_produto', 'pnome'),
                    'cardinalidade' => '1n'//nn 1n 11
                )
           ),
        );

        $this->LoadResource("formulario", 'form');
        $this->form->NewForm($dados, $_POST, array(), false);
    }
    
}

?>
