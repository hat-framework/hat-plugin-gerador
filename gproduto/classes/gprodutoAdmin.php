<?php

class gprodutoAdmin extends Admin{
    
    public $model_name = "gerador/gproduto";    
    public function gerarProduto(){
        if(!empty ($_POST)) $this->registerVar("item", $this->model->gerarProduto($_POST['produto']));
        else $this->registerVar("item", "");
        
        $this->setVars($this->model->getMessages());
        $this->display($this->autoaction);
    }

}

?>
