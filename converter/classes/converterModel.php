<?php

class gerador_converterModel extends \classes\Model\Model{
    
    private $plugin = array();
    private $plugprod = array();
    private $LastPluginName = '';
    public function __construct() {
        parent::__construct();
        
        $this->LoadModel('gerador/gproduto', 'prod');
        $this->LoadModel('gerador/Config/produto_plugin', 'pp');
        $this->LoadModel('gerador/gplugin', 'plug');
        $this->LoadModel('gerador/gdados' , 'dado');
        $this->LoadModel('gerador/widget' , 'wid');
        
    }
    
    private function reset($name){
        $tb1 = $this->prod->getTable();
        $tb2 = $this->plug->getTable();
        $sql = "DELETE FROM $tb1; DELETE FROM $tb2;";
        $this->db->ExecuteQuery($sql);
        
        $this->LoadResource("files/dir", 'dir');
        $this->dir->remove(GERADOR. $name);
    }
    
    private function inserirProduto($name){
        $this->reset($name);
        
        $class = 'prod';
        $arr   = 'produto';
        $item = $this->$class->getItem($name, 'pnome');
        if(!empty ($item)){
            $this->$arr = $item;
            return true;
        }
        
        $inserir['pnome']    = $name;
        $bool = $this->$class->inserir($inserir);
        $this->setMessages($this->$class->getMessages());
        if($bool === true){
            $item = $this->$class->getItem($name, 'pnome');
            $this->$arr = $item;
        }
        return $bool;
    }
    
    private function addToProd($cod_plugin){
        $cod = $this->produto['cod_produto'];
        $inserir['cod_produto'] = $cod;
        $inserir['cod_plugin'] = $cod_plugin;
        $var = serialize($inserir);
        if(array_key_exists($var, $this->plugprod)) return true;
        $this->plugprod[$var] = true;
        $item = $this->pp->selecionar(array(), "cod_produto = '$cod' && cod_plugin = '$cod_plugin'");
        if(!empty ($item)) return true;
        if(!$this->pp->inserir($inserir)){
            die($this->pp->getErrorMessage());
        }
    }
    
    
    private function inserirPlugin($plugin){
        
        $plugin = GetPlainName($plugin);
        if(array_key_exists($plugin, $this->plugin))return true;
        
        $item = $this->plug->getItem($plugin, 'plugnome');
        if(!empty ($item)){
            $this->plugin[$plugin] = $item;
            $this->addToProd($item['cod_plugin']);
            return true;
        }
        
        $inserir['plugnome']    = $plugin;
        $inserir['obrigatorio'] = 'n';
        $bool = $this->plug->inserir($inserir);
        $this->setMessages($this->plug->getMessages());
        if($bool === true){
            $item = $this->plug->getItem($plugin, 'plugnome');
            $this->plugin[$plugin] = $item;
            $this->addToProd($item['cod_plugin']);
        }
        return $bool;
    }
    
    private function inserirWidget($widget){

        $temp = explode(")", $widget);
        $count = 0;
        if(count($temp) < 2) die("widget $widget não possui um plugin especificado!");
        $plugin = array_shift($temp); $plugin = str_replace("(", "", $plugin);
        $widget = array_shift($temp); $widget = substr($widget, 1, strlen($widget));    
        $plugin = GetPlainName($plugin);
        if(!$this->inserirPlugin($plugin)) return false;
        
        $this->LastPluginName = $plugin;
        $widget = GetPlainName($widget);
        $widget = str_replace("-", "", $widget);
        $item = $this->wid->getItem($widget, 'wnome');
        if(!empty ($item)){
            $this->widget = $item;
            return true;
        }
        
        $plugname = $this->plugin[$plugin]['plugnome'];
        $inserir['cod_plugin']   = $this->plugin[$plugin]['cod_plugin'];
        $inserir['wnome']        = $widget;
        $inserir['tabela']       = GetPlainName($plugname."_".$widget);
        $inserir['obrigatorio']  = "s";
        $inserir['documentacao'] = "Widget $plugname";
        
        $bool = $this->wid->inserir($inserir);
        $this->setMessages($this->wid->getMessages());
        if($bool === true){
            $item = $this->wid->getItem($widget, 'wnome');
            $this->widget = $item;
        }
        return $bool;
    }
    
    private function inserirDados($name, $dados){
        
        $cod_widget = $this->widget['cod_widget'];
        $item = $this->dado->selecionar(array(), "cod_widget = '$cod_widget' AND dnome = '$name'");
        if(!empty ($item)){return true;}
        
        $plugin = $this->LastPluginName;
        $dados['cod_plugin']   = $this->plugin[$plugin]['cod_plugin'];   
        $dados['cod_widget']   = $this->widget['cod_widget'];        
        $bool = $this->dado->inserir($dados);
        $this->setMessages($this->dado->getMessages());
        return $bool;
    }


    public function InsertDesign($post){
        if(!isset($post['xml'])) return false;
        if(!isset($post['produto']))return false;
        //print_r($post); die('foo');
        if($post['produto'] === 'sqldesigner'){
            $this->setErrorMessage('O nome do produto não pode ser sqldesigner');
            return false;
        }
        $produto = $post['produto'];
        if(!$this->inserirProduto($produto)) return false;
        
        $var    = $post['xml'];
        $this->LoadResource("files/xml", "xml");
        $array = $this->xml->xml2array($var, 1, '');
        $array = array_shift($array);
        //$tmp   = $array;
        $array = $array['table'];
        foreach($array as $rows){      
            if(!isset($rows['@attributes']['name'])) die('Gerador Erro: Nome da classe não existe!');
            $name = $rows['@attributes']['name'];
            if(!$this->inserirWidget($name)) return false;
            $out = array();
            foreach($rows['row'] as $row){
                if(!is_array($row)){continue;}
                $name2 = @$row['@attributes']['name'];
                //echo $name2 . "<br/>";
                $key = GetPlainName($name2);
                if(array_key_exists('relation', $row)){
                    if(array_key_exists('@attributes', $row['relation'])){
                        $model   = str_replace(array("(", ")", " "), array("", "", "_"), $row['relation']['@attributes']['table']);
                        $model   = GetPlainName($model);
                        $key_ref = GetPlainName($row['relation']['@attributes']['row']);
                        $model   = str_replace("_", '/', $model);
                        $out[$key]['fkey']           = true;
                        $out[$key]['fkeymodel']      = $model;
                        $out[$key]['fkeycolumn']     = $key_ref;
                        $out[$key]['fkeyshowcolumn'] = $key_ref;
                        $out[$key]['fkeycard']       = '1n';
                    } else {
                        print_r($row['relation']);
                        debugarray ($row['relation']);
                        die('Erro! Não existe a chave relation');
                    }
                }
                $size = "FUNC_NULL";
                $type = explode("(", @$row['datatype']);
                if(count($type) > 1) {
                    $size = end($type);
                    $size = str_replace(array("(", ")"), "", $size);
                    $type = array_shift($type);
                }else $type = array_shift ($type);
                $type = strtolower($type);
                
                if($size == "FUNC_NULL"){
                    if(!isset($out[$key]['fkey'])){
                        $arr = array('integer' => 11, 'varchar' => 64);
                        if(array_key_exists($type, $arr)){
                            $this->setAlertMessage("Gerador Error: Atributo Size da classe [$name][$name2] não existe");
                            $size = $arr[$type];
                        } 
                    }
                }
                
                $notnull = (@$row['@attributes']['null'] == '1')         ? "n": 's';
                $ai      = (@$row['@attributes']['autoincrement'] == '1')? "s": 'n';
                //if($key == 'dstipomercado6'){
                //    print_r($row);
                //    die($notnull);
                //}
                $out[$key]['grid']           = 's';
                $out[$key]['display']        = 's';
                $out[$key]['dnome']          = $key;
                $out[$key]['label']          = $name2;
                $out[$key]['type']           = $type;
                $out[$key]['enumset']        = $size;
                $out[$key]['size']           = $size;
                $out[$key]['notnull']        = $notnull;
                $out[$key]['auto_increment'] = $ai;
                $out[$key]['unico']          = 'n';
                $out[$key]['default']        = @$row['default'];
                $out[$key]['search']         = 'n';
                
                foreach($out[$key] as $tname => &$temp){
                    $temp = str_replace('  ', '', $temp);
                    if($temp == "" || $temp == " ")unset($out[$key][$tname]);
                }
                
                if(strtolower(@$out[$key]['type']) == "integer")
                    $out[$key]['type'] = 'int';
                
                if(strtolower(@$out[$key]['type']) == "text")
                    unset($out[$key]['type']);
                
                if(@$out[$key]['auto_increment'] == "0")
                    unset($out[$key]['auto_increment']);
            }
            if(isset($rows['key'])){
                if(isset($rows['key']['@attributes']['type'])){
                    $rows['key'][] = $rows['key'];
                }
                
                foreach($rows['key'] as $rk){
                    
                    if(!is_array($rk)) continue;
                    if(!array_key_exists("@attributes", $rk)) continue;
                    if(!array_key_exists("part", $rk)) continue;
                    $ktype = $rk['@attributes']['type'];
                    $key   = $rk['part'];
                    if(!is_array($key)) {
                        $key = array();
                        $key[] = $rk['part'];
                    }

                    //faz a tradução entre os tipos
                    if($ktype == "PRIMARY")       $ktype = 'pkey';
                    elseif($ktype == "UNIQUE")    $ktype = 'unique';
                    elseif($ktype == "INDEX")     $ktype = 'index';

                    foreach($key as $k){
                        $k = GetPlainName($k);
                        $out[$k][$ktype] = "s";
                        //echo "($name2 $k)<br/>";
                    }
                }
                
            }

            $name = GetPlainName($name);
            $debugar[$name] = $out;
            foreach($out as $tmname => $o){
                if(isset($o['type']) && ($o['type'] == 'text' || $o['type'] == 'blob')){
                    $o['grid']    = 'n';
                    $o['display'] = 'n';
                }elseif(array_key_exists("primary", $o) && $o['primary'] == 's'){
                    $o['grid']    = 's';
                    $o['display'] = 's';
                }
                
                if((array_key_exists("unique", $o) && $o['unique'] == 's')|| 
                   (array_key_exists("index", $o)  && $o['index']  == 's') ){
                    $o['search'] = 's';
                }
                if(!$this->inserirDados($tmname, $o)) return false;
            }
        }
        //return debugarray($tmp);
        //return debugarray($debugar);
        //return debugarray($test);
        //return debugarray($array);
        //return($array);
        $this->LoadModel('gerador/gproduto', 'gprod');
        $bool = $this->gprod->gerarProduto($this->produto['cod_produto']);
        $this->setMessages($this->gprod->getMessages());
        if($bool) $this->setSuccessMessage("Produto ($produto) inserido corretamente!");
        return $bool;
    }
    
    public function getForm(){
        $arr = array(
            'produto' => array(
                'name'    => "Nome do produto",
                'type'    => 'varchar',
             ),
            'xml' => array(
                'name'    => "Cole o Xml gerado pelo SqlDesign",
                'type'    => 'text',
             )
        );
        return $arr;
    }
    
}

?>