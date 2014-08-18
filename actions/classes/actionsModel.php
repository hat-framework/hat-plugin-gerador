<?php

class gerador_actionsModel extends \classes\Model\Model{
    public function readXml($file){
        $this->LoadResource('files/xml', 'xml');
        $arr = $this->xml->getXmlArray($file);
        if($arr === false) die($this->xml->getErrorMessage());
        $out = array();
        foreach($arr['mxGraphModel']['root']['mxCell'] as $a){
            if(!isset($a['@attributes']['value'])) continue;
            if(isset($a['@attributes']['edge'])) continue;
            $a['@attributes']['value'] = strip_tags(str_replace(array("\n", '\t', '  '), '', $a['@attributes']['value']));
            
            if(trim($a['@attributes']['value']) == "") continue;
            if(strstr($a['@attributes']['value'], 'page:') === false)  continue;
            
            $exp = explode(';', $a['@attributes']['value']);
            $temp = array();
            foreach($exp as $e){
                $str = explode(":", $e);
                $title = array_shift($str);
                $content = array_shift($str);
                if(trim($content) == "") continue;
                if(strstr("rgb", $content)) continue;
                
                $temp[$title] = $content;
            }
            $out[] = $temp;
        }
        debugarray($out);
    }
}