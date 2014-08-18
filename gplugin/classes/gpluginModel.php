<?php 
class gerador_gpluginModel extends \classes\Model\Model{
    public $tabela = "gerador_plugin";
    public $pkey   = "cod_plugin";
    public $dados  = array(
        'cod_plugin' => array(
            'name'    => "Código do plugin",
            'pkey'    => true,
            'ai'      => true,
            'type'    => 'int',
            'grid'    => true,
            'notnull' => true
        ),
        
        'plugnome' => array(
            'name'    => 'Nome',
            'type'    => 'varchar',
            'size'    => '50', 
            'unique'  => array('model' => 'gerador/gplugin'),
            //'search'  => true,
            'grid'    => true,
            'notnull' => true
       	)
        
    );
    
    
    public function gerar($cod_plugin, $file){
        $plugin = $this->getItem($cod_plugin);
        if(empty ($plugin)){
            $this->setErrorMessage("Plugin não existe!");
            return false;
        }
        $this->LoadResource("files/dir" , 'dir');
        $this->LoadResource("files/file", 'file');
        if(!$this->genfiles($plugin['plugnome'], $file)){
            $this->setErrorMessage($this->gw->getErrorMessage());
            return false;
        }
        
        $this->LoadModel("gerador/widget", 'gw');
        if(!$this->gw->gerar($cod_plugin, $file.$plugin['plugnome'], $plugin['plugnome'])){
            $this->setMessages($this->gw->getMessages());
            return false;
        }
        
        $this->setMessages($this->gw->getMessages());
        $alert = $this->getAlertMessage();
        $erro  = $this->getErrorMessage();
        if($alert != "" || $erro != ""){
            if($alert != "") $this->setAlertMessage($alert);
            if($erro  != "") $this->setErrorMessage($erro);
            return false;
        }
        
        $wid = $this->gw->getWidgetsByPlugin($cod_plugin);
        if(!$this->savefile($file.$plugin['plugnome']."/Config/".$plugin['plugnome']."Actions.php",
                "action", array($plugin['plugnome'], $wid)))
                return false;
        
        $this->setSuccessMessage("Plugin ".$plugin['plugnome']." gerado corretamente!");
        return true;
    }
    
    private function genfiles($nome, $file){
        $nome = strtolower($nome);
        if(!$this->dir->create($file, $nome))                    {$this->setMessages($this->dir->getMessages()); return false;}
        if(!$this->dir->create($file."$nome/", "Config"))        {$this->setMessages($this->dir->getMessages()); return false;}
        if(!$this->dir->create($file."$nome/Config/", "Install")){$this->setMessages($this->dir->getMessages()); return false;}
        
        if(!$this->dir->create($file."$nome/", "index"))         {$this->setMessages($this->dir->getMessages()); return false;}
        if(!$this->dir->create($file."$nome/index/", "classes")) {$this->setMessages($this->dir->getMessages()); return false;}
        if(!$this->savefile($file."$nome/Config/$nome"."Loader.php","loader", array($nome)))           return false;
        if(!$this->savefile($file."$nome/Config/$nome"."Install.php","install", array($nome))) return false;
        if(!$this->savefile($file."$nome/index/classes/indexAdmin.php","index", ""))                   return false;
        if(!$this->savefile($file."$nome/index/classes/indexController.php","controller", "index"))    return false;
        
        return true;
    }
    
    private function savefile($filename, $template, $arr){

        $this->LoadModel("gerador/templates/$template"."template", 'lt');
        $data = $this->lt->getTemplate($arr);
        if(file_put_contents($filename, $data) === false){
            $this->setErrorMessage("Não foi possível criar o arquivo ($filename) ");
            return false;
        }
        return true;
    }
}