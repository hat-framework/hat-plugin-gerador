<?php 
class gerador_widgetModel extends \classes\Model\Model{
    public $tabela = "gerador_widget";
    public $pkey   = "cod_widget";
    public $dados  = array(
        
        'cod_widget' => array(
            'name'    => "Código",
            'pkey'    => true,
            'ai'      => true,
            'type'    => 'int',
            'grid'    => true,
            'notnull' => true
         ),
        
        'cod_plugin' => array(
            'name'      => 'Plugin',
            'type' 	=> 'int',
            'size'      => '11',
            'grid'      => true,
            'fkey'      => array(
                'model' 	=> 'gerador/gplugin', 
                'keys'          => array('cod_plugin', 'plugnome'),
                'cardinalidade' => '1n',//nn 1n 11
                'onupdate'      => 'cascade',
                'ondelete'      => 'cascade'
            )
         ),
        
        'wnome' => array(
            'name'    => 'Nome',
            'type'    => 'varchar',
            'size'    => '50', 
            'unique'  => array('model' => 'gerador/widget'),
            //'search'  => true,
            'grid'    => true,
            'notnull' => true
       	),
        
        'tabela' => array(
            'name'    => 'Tabela',
            'type'    => 'varchar',
            'size'    => '50',
            'grid'    => true,
            'notnull' => true
       	),
        
        'documentacao' => array(
            'name'    => 'Documentação',
            'type'    => 'text',
            //'search'  => true,
            //'especial'=> 'editor',
            'notnull' => true
        ),
        /*
        
        'dados' => array(
            'name'      => 'Dados',
            'type' 	=> 'int',
            'fkey'      => array(
                'model' 	=> 'gerador/gdados', 
                'keys'          => array('cod_dados', 'dnome'),
                'cardinalidade' => 'n1'//nn 1n 11
            )
         )*/
    );
    
    public function getWidgetsByPlugin($cod_plugin){
        return $this->selecionar(array(), "cod_plugin = '$cod_plugin'");
    }
    public function gerar($cod_plugin, $file, $plugnome){
        $this->LoadModel('gerador/gdados', 'gd');
        $this->LoadResource("files/file", 'fobj');
        $this->LoadResource("files/dir", 'dobj');
        
        $alert = "";
        $widgets = $this->getWidgetsByPlugin($cod_plugin);
        foreach($widgets as $wid){
            extract($wid);
            $wnome = strtolower($wnome);
            if(!$this->dobj->create("$file/", $wnome) ||
               !$this->dobj->create("$file/$wnome/", "classes")){
                $alert .= $this->dobj->getErrorMessage() . "<br/>";
                continue;
            }
            $createdir = $file.strtolower("/$wnome/classes/");
            if(!$this->genFiles($wid, $createdir, $plugnome)) return false;
        }

        if($alert != "") $this->setAlertMessage ($alert);
        else $this->setSuccessMessage("Widget Gerado corretamente!");
        return true;
    }
    
    private function genFiles($wid, $dir, $plugnome){

        //inicializa as variáveis
        $plugnome = strtolower($plugnome);
        $wnome    = strtolower($wid['wnome']);
        $filename = "$dir$wnome";
        $model    = $wid['tabela'];
        $modelnm  = str_replace("_", "/", $model);
        $dados    = $this->gd->prepareModel($wid['cod_widget'], $modelnm);
        $pkey     = $this->gd->getPks();
        

        //salva o model
        $this->LoadModel("gerador/templates/modeltemplate", 'mt');
        $conteudo = $this->mt->getTemplate($plugnome, $wnome , $model , $pkey, $dados);
        if(!$this->fobj->savefile($filename."Model.php", $conteudo)){
            $this->setErrorMessage($this->fobj->getErrorMessage());
            return false;
        }
        
        //salva o data
        $this->LoadModel("gerador/templates/datatemplate", 'mt');
        $conteudo = $this->mt->getTemplate($plugnome, $wnome , $model , $pkey, $dados);
        if(!$this->fobj->savefile($filename."Data.php", $conteudo)){
            $this->setErrorMessage($this->fobj->getErrorMessage());
            return false;
        }

        //salva o controller da área admin
        $this->LoadModel("gerador/templates/admintemplate", 'mt');
        $conteudo = $this->mt->getTemplate($wnome , $modelnm);
        if(!$this->fobj->savefile($filename."Admin.php", $conteudo)){
            $this->setErrorMessage($this->fobj->getErrorMessage());
            return false;
        }

        //salva o controller da área do usuário
        $this->LoadModel("gerador/templates/controllertemplate", 'mt');
        $conteudo = $this->mt->getTemplate($wnome , $modelnm);
        if(!$this->fobj->savefile($filename."Controller.php", $conteudo)){
            $this->setErrorMessage($this->fobj->getErrorMessage());
            return false;
        }

        //salva o componente
        $this->LoadModel("gerador/templates/componenttemplate", 'mt');
        $conteudo = $this->mt->getTemplate($wnome);
        if(!$this->fobj->savefile($filename."Component.php", $conteudo)){
            $this->setErrorMessage($this->fobj->getErrorMessage());
            return false;
        }
        
        $this->LoadModel("gerador/templates/actiontemplate", 'lt');
        $this->lt->setTempTemplate(array($wnome, $modelnm, $plugnome));
        return true;
    }
    
    
}
?>