<?php 
class gerador_gdadosModel extends \classes\Model\Model{
    public $tabela = "gerador_gdados";
    public $pkey   = "cod_dados";
    public $dados  = array(
                
        'cod_dados' => array(
            'name'    => "Dados",
            'pkey'    => true,
            'ai'      => true,
            'type'    => 'int',
            'grid'    => true,
            'notnull' => true
         ),
        
        'cod_widget' => array(
            'name'      => 'Widget',
            'type' 	=> 'int',
            'grid'    => true,
            'notnull'   => true,
            'fkey'      => array(
                'model' 	=> 'gerador/widget', 
                'keys'          => array('cod_widget', 'wnome'),
                'cardinalidade' => '1n',//nn 1n 11
                'onupdate'      => 'cascade',
                'ondelete'      => 'cascade',
            )
         ), 
        
        'label' => array(
            'name'    => 'Label',
            'type'    => 'varchar',
            'size'    => '127', 
            'grid'    => true,
            'notnull' => true
       	),
        
        'dnome' => array(
            'name'    => 'Coluna (SQL)',
            'type'    => 'varchar',
            'size'    => '50', 
            'grid'    => true,
            'notnull' => true
       	),
        
        'notnull' => array(
            'name'      => 'Notnull',
            'type'      => 'enum',
            'default'   => 's',
            'grid'      => true,
            'options'   => array(
                's' => 'Sim',
                'n' => 'Não'
            ),
            'notnull'   => true
       	 ),
        
        'auto_increment' => array(
            'name'      => 'Auto Increment',
            'type'      => 'enum',
            'default'   => 'n',
            'grid'      => true,
            'options'   => array(
                's' => 'Sim',
                'n' => 'Não'
            ),
            'notnull'   => true
       	 ),
        
        'pkey' => array(
            'name'      => 'Primary Key',
            'type'      => 'enum',
            'default'   => 'n',
            'grid'    => true,
            'options'   => array(
                's' => 'Sim',
                'n' => 'Não'
            ),
            'notnull'   => true
       	 ),
        
        'unique' => array(
            'name'      => 'Único(Unique key)',
            'type'      => 'enum',
            'default'   => 'n',
            'options'   => array(
                's' => 'Sim',
                'n' => 'Não'
            ),
            'notnull'   => true
       	 ),
        
        'index' => array(
            'name'      => 'Índice(Index)',
            'type'      => 'enum',
            'default'   => 'n',
            'options'   => array(
                's' => 'Sim',
                'n' => 'Não'
            ),
            'notnull'   => true
       	 ),

        'display' => array(
            'name'      => 'Display(Exibir nas página de listagem)',
            'type'      => 'enum',
            'default'   => 'n',
            'options'   => array(
                's' => 'Sim',
                'n' => 'Não'
            ),
            'notnull'   => true
       	 ),
        
        'grid' => array(
            'name'      => 'Grid(Exibir no grid)',
            'type'      => 'enum',
            'default'   => 'n',
            'options'   => array(
                's' => 'Sim',
                'n' => 'Não'
            ),
            'notnull'   => true
       	 ),
        
        'search' => array(
            'name'      => 'Search(Indexar campo na pesquisa)',
            'type'      => 'enum',
            'default'   => 'n',
            'options'   => array(
                's' => 'Sim',
                'n' => 'Não'
            ),
            'notnull'   => true
       	 ),
        
        'descricao' => array(
            'name'    => 'Descrição',
            'type'    => 'varchar',
            'size'    => '254'
       	),
        
        'type' => array(
            'name'     => 'Tipo',
            'type'     => 'varchar',
            'especial' => 'listfolder',
            'notnull'   => true, 
            'listfolder' => array(
                "hide"   => array(''),
                'replace' => array('Type')
            ),
            'size'     => '50', 
            'grid'     => true
         ),
        
        'enumset' => array(
            'name'     => 'Size(Opções entre vírgulas para enum/set)',
            'type'     => 'varchar',
            'size'     => '255', 
         ),
        
        'etype' => array(
            'name'    => 'Tipo Especial',
            'type'     => 'varchar',
            'especial' => 'listfolder',
            'listfolder' => array(
                "hide"   => array(''),
                'replace' => array('Especial')
            ),
            'size'    => '64'
         ),
        
        'eargs' => array(
            'name'    => 'Argumentos Especiais',
            'type'    => 'varchar',
            'size'    => '254'
         ),
        
        'fkey' => array(
            'name'      => 'Chave Estrangeira',
            'type' 	=> 'enum',
            'default'   => 'n',
            'grid'      => true,
            'options'   => array('s' => 'Sim', 'n' => 'Não'),
       	 ),
        
        'fkeymodel' => array(
            'name'      => 'Fkey Model',
            'type' 	=> 'varchar',
            'size'      => '64',
            'especial' => 'dinamic',
            'dinamic' => array(
                'field' => 'fkey',
                'value' => 's',
                'onselect_value' => 'show'//show, executequery
            )
       	 ),
        
        'fkeycolumn' => array(
            'name'      => 'Fkey Column',
            'type' 	=> 'varchar',
            'size'      => '64',
            'especial' => 'dinamic',
            'dinamic' => array(
                'field' => 'fkey',
                'value' => 's',
                'onselect_value' => 'show',//show, find
               /* 'find'  => array('model' => 'modelname', 'column' => 'columnname', 'showcolumn' => 'showcolname') 
                * valor da coluna é o mesmo do field selecionado*/
            )
       	 ),
        
        'fkeyshowcolumn' => array(
            'name'      => 'Fkey Show Colunm',
            'type' 	=> 'varchar',
            'size'      => '64',
            'especial' => 'dinamic',
            'dinamic' => array(
                'field' => 'fkey',
                'value' => 's',
                'onselect_value' => 'show',//show, find
               /* 'find'  => array('model' => 'modelname', 'column' => 'columnname', 'showcolumn' => 'showcolname') 
                * valor da coluna é o mesmo do field selecionado*/
            )
            
       	 ),
        
        'fkeycard' => array(
            'name'      => 'Cardinalidade',
            'type'      => 'enum',
            'default'   => '',
            'options'   => array(
                ''   => 'Nenhuma',
                '11' => '11',
                '1n' => '1N',
                'nn' => 'NN'
            ),
            'especial' => 'dinamic',
            'dinamic' => array(
                'field' => 'fkey',
                'value' => 's',
                'onselect_value' => 'show',//show, find, extrafield
               /* 'find'  => array('model' => 'modelname', 'column' => 'columnname', 'showcolumn' => 'showcolname') 
                * valor da coluna é o mesmo do field selecionado 
                */
            )
       	 )
    );
    
    private $pks = array();
    public function __construct() {
        $this->LoadModel("gerador/widget", 'wm');
        $this->twidget = $this->wm->getTable();
        
        $this->LoadModel("gerador/gplugin", 'gp');
        $this->tplugin = $this->gp->getTable();
        $filename = classes\Classes\Registered::getResourceLocation('formulario', true);
        $this->dados['type']['listfolder']['folder']  = $filename."/src/lib/types";
        $this->dados['etype']['listfolder']['folder'] = $filename."/src/lib/especial";
        parent::__construct();
    }
    
    public function prepareModel($cod_widget, $modelnm){
        $add = $v = "";
        $this->modelnm = $modelnm;
        $dados = $this->selecionar(array(), "cod_widget = '$cod_widget'", "", "", "cod_dados ASC");
        //$dados = $this->selecionar(array(), "fkeymodel  = '$modelnm' AND cod_widget != '$cod_widget'", "", "", "cod_dados ASC");
        //echo $this->db->getSentenca();
        //debugarray($dados);
        //die();
        foreach($dados as $d){
            $add .= $v.$this->prepare($d, $modelnm);
            $v = ",";
        }
        $add .= $v.$this->prepareButton($modelnm);
        return $add;
    }
    
    private function prepare($dados, $modelnm){
        
        $this->j = "\n\t    ";
        $this->k = "\n        ";
        extract($dados);
        $add  = "";        
        $dnome = str_replace(array(" ", "-"), "", $dnome);
        $add .= "$this->k '$dnome' => array(";
            $add .= $this->prepareLabel($label, $fkeymodel);
            $add .= $this->filtherType($dados);
            $add .= $this->filtherOthers($dados);
            $add .= $this->genFkey($fkeymodel, $fkeycolumn, $fkeyshowcolumn, $fkeycard);
        $add .= "$this->k)";
        if(($pkey == 's')) $this->pks[] = $dnome;
        
        return $add;
    }
    
    private function prepareButton($modelnm){
        $name = explode("/", $modelnm);
        $name = ucfirst(end($name));
        return "$this->j'button'     => array('button' => 'Gravar $name'),";
    }
    
    private function prepareLabel($label, $fkeymodel){
        $temp = explode("_", $label);
        $label = ucfirst(end($temp));
        if($fkeymodel != ""){
            array_shift($temp);
            $label = array_shift($temp);
            $label = ucfirst($label);
        }
        if($label == "Cod") $label = "Código";
        return "$this->j'name'     => '$label',";
    }
    
    private function getType($type){
        $type      = trim(strtolower($type));
        $substypes = array('integer' => 'int', "mediumtext" => 'text');
        if(array_key_exists($type, $substypes)){
            $type = $substypes[$type];
        }
        return $type;
    }
    
    private function filtherType($dados){
        extract($dados);
        $type = $this->getType($type);
        $add = "$this->j'type'     => '$type',";
        switch ($type){
                case 'enum':
                case 'set':
                    $options = explode(",",$enumset);
                    $default = GetPlainName($options[0]);
                    $add .= "$this->j'default' => '$default',";
                    $add .= "$this->j'options' => array(";
                    foreach($options as $opt){
                        if(substr($opt, 0, 1) == " ") $opt = substr($opt, 1, strlen($opt));
                        $opt1 = GetPlainName($opt);
                        $opt2 = $opt;
                        $add .= "$this->j\t'$opt1' => '$opt2',";
                    }
                    $add .= "$this->j),";
                    break;
                case 'bit':
                    $add .= "$this->j'default' => '0',";
                    break;
                case 'decimal':
                    $add .= "$this->j'especial' => 'monetary',";
                    break;
                default :
                    static $char = array('varchar', 'text');
                    if($type == "timestamp") $add .= "'private' => true,";
                    elseif(in_array($type, $char)){
                        if($type == "text" || (isset($size) && $type == 'varchar' && $size > 200))
                            $add .= "$this->j'especial' => 'editor',";
                    }
                    if($enumset != "") $add .= "$this->j'size'     => '$enumset',";
        }
        return $add;
    }
    
    private function filtherOthers($dados){
        extract($dados);
        $add  = ($etype          == "") ? "": "$this->j'especial'   => '$etype',";
        $add .= ($descricao      == "") ? "": "$this->j'descricao'  => '$descricao',";
        $add .= ($pkey           == 's')? "$this->j'pkey'    => true,":"";
        $add .= ($auto_increment == 's')? "$this->j'ai'      => true,":"";
        $add .= ($notnull        == 's')? "$this->j'notnull' => true,":"";
        $add .= ($unique         == 's')? "$this->j'unique'  => array('model' => '$this->modelnm'),":"";
        $add .= ($index          == 's')? "$this->j'index'   => true,":"";
        $add .= ($grid           == 's')? "$this->j'grid'    => true,":"";
        $add .= ($display        == 's')? "$this->j'display' => true,":"";
        $add .= ($pkey == 's' && $fkeymodel == "")? "$this->j'private' => true":"";
        return $add;
    }
    
    private function genFkey($model, $column, $fkeyshowcolumn, $card){
        if($model == "" || $column == "" || $fkeyshowcolumn == "" || $card == "") return;
        $t = "$this->j    ";
        $add = "";
        if($card == "1n" && $model != "usuario/login") {
            $add  = "$this->j'especial' => 'session',";
            $add .= "$this->j'session'  => '$model',";
        }
        $add .= "$this->j'fkey' => array(";
        $add .= "$t'model' => '$model',";
        $add .= "$t'cardinalidade' => '$card',";
        $add .= "$t'keys' => array('$column', '$fkeyshowcolumn'),";
        $add .= "$this->j),";
        return $add;
    }
    
    public function getPks(){
        $temp = (count($this->pks) > 1)? $this->pks: $this->pks[0];
        $this->pks = array();
        return $temp;
    }
}
?>