<?php
//protected $dados = array(
//        'pluglabel'   => 'Api',
//        'isdefault'   => 'n',
//        'system'      => 'n',
//        'description' => 'Api de acesso aos dados do site, usando o padrão publisher subscriber implementado via html',
//    );
use classes\Classes\Object;
class GenClass extends classes\Classes\Object{
    
    public function generate_class($input, $dir){	
        
            if(!$this->validate($input)) return false;
            $template = $this->get_template($input);
            $filename = $input['name'];
            if(!$this->SaveFile($dir, $filename, $template)) return false;
            
            $this->setSuccessMessage("Classe $filename criada corretamente no diretorio $dir");
            return true;

    }
    
    private function SaveFile($dir, $filename, $conteudo){
        $this->LoadResource('files/dir', 'dobj');
        if(!$this->dobj->create($dir, "", 0755)){
            $this->setErrorMessage($this->fobj->getErrorMessage());
            return false;
        }
        
        $this->LoadResource('files/file', 'fobj');
        if(!$this->fobj->savefile($filename, $conteudo)){
            $this->setErrorMessage($this->fobj->getErrorMessage());
            return false;
        }
        return true;
    }
    
    private function validate(&$input){
        // Did the user specify a name for the class?
        if (!isset($input['class']) || empty($input['class'])){
            $this->setErrorMessage("O nome da Classe não pode ser vazio");
            return false;
        }
        if (!isset($input['extends'])) $input['extends'] = "";
        if (!isset($input['methods']))$input['methods'] = array();
    }
        
    private function get_template($input){
        $class 	 = strtolower($input['class']);
	$extends = strtolower($input['extends']);
        $methods = $input['methods'];
        if(!empty ($methods)){
            foreach($methods as $name => $method)
                 $methods_string .= $this->create_method($name, $method);
        }
        return $this->create_class($class, $extends, $method_string);
    }
    
    private function create_class($name, $extends, $methods_string){
        $extends = ($extends == "")?"": "extends $extends";
        $template = <<<CLASS
        <?php 
        class $name $extends{

            $methods_string

        }
        ?>
CLASS;
    }
    
    private function create_method($name, $method_string){
            return "\tpublic function $name(){\n\n\t\t $method_string \n\n }\n\n";
    }
}