<?php

class gpluginAdmin extends Admin{
    
    public $model_name = "gerador/gplugin";
    public function gerar(){
        if(!empty ($_POST)) $this->registerVar("item", $this->model->gerar($_POST['plugin'], GERADOR));
        else $this->registerVar("item", "");
        
        $this->setVars($this->model->getMessages());
        $this->display($this->autoaction);
    }

}

?>
