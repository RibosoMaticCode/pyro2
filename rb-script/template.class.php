<?php
//esta es la clase
// credito: http://www.comocreartuweb.com/consultas/showthread.php/57935-Sistema-de-plantillas-PHP
class TemplateClass{
    //Declaraciones

    private $_dir           = ''; //carpeta de los archivos .tpl (los templates)
    private $_file_ext      = '.tpl'; //formato de los templates, (default = .tpl)
    private $_vars          = array(); //variables a transformar
    private $_delimiters    = array('{', '}'); //limitadores para saber donde tiene que buscar (ejemplo = {ejemplo})

    public function DirTemplate($value){
        $this->_dir = $value;
    }

    public function Assign($name, $value){
        if(!array_key_exists($name, $this->_vars))
            $this->_vars[$name] = $value;
    }

    /*public function GetAssign($name){
        return $this->_vars{$name};
    }*/

    public function Template($file){

        if( $output = @file_get_contents($this->_dir.$file.$this->_file_ext)){
            foreach($this->_vars as $name => $value){
                $output = str_replace($this->_delimiters[0].$name.$this->_delimiters[1], $value, $output);
            }
            return $output;
        }
        else
            return $this->_dir.$file.$this->_file_ext." La plantilla no existe.";
    }
}
?>
