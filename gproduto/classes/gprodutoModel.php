<?php 
class gerador_gprodutoModel extends \classes\Model\Model{
    public $tabela = "gerador_produto";
    public $pkey   = "cod_produto";
    public $dados  = array(
        'cod_produto' => array(
            'name'    => "Código do produto",
            'pkey'    => true,
            'ai'      => true,
            'type'    => 'int',
            'grid'    => true,
            'notnull' => true
         ),
        
        'pnome' => array(
            'name'    => 'Nome',
            'type'    => 'varchar',
            'size'    => '50', 
            'unique'  => array('model' => 'gerador/gproduto'),
            //'search'  => true,
            'grid'    => true,
            'notnull' => true
       	),
        
        'cod_plugin' => array(
            'name'      => 'Plugins',
            'type' 	=> 'int',
            'fkey'      => array(                
                'cardinalidade' => 'nn',//nn 1n 11
                'model' 	=> 'gerador/Config/produto_plugin', 
                'keys'          => array('cod_plugin', 'plugnome'),
                'formmodel'     => 'gerador/plugin',
                'onupdate'      => 'cascade',
                'ondelete'      => 'cascade'
            )
         )
    );
    
    public function gerarProduto($cod, $folder = GERADOR){
        $item = $this->getItem($cod);
        if(empty ($item)){
            $this->setErrorMessage("Produto não existe!");
            return false;
        }
        $this->LoadResource("files/dir" , 'dir');
        $nome = strtolower($item['pnome']);
        
        $arq = $folder . $nome."/";
        $this->dir->remove($arq);
        if(!$this->dir->create($folder, $nome)){$this->setMessages($this->dir->getMessages()); return false;}
        
        $this->LoadModel('gerador/gplugin', 'gplug');
        $item = $item['cod_plugin'];
        foreach($item as $it){
            if(!$this->gplug->gerar($it['cod_plugin'], $arq)){
                $this->setErrorMessage($this->gplug->getErrorMessage());
                return false;
            }
        }
       
        $this->setSuccessMessage("Produto ($nome) gerado corretamente");
        return true;
    }
}
?>