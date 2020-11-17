<?php

class CSV {
  function __construct(){	}

  private $output = "";

  private function get_content($file_name = ""): string {

    if(!$this->validate_filename($file_name)){
      return "";
    }

    $file = file_get_contents($file_name);
    return strval($file);
  }

  private function validate_filename($file_name): bool {
    if($file_name == "" || !$this->exits($file_name)){
      return false;
    }

    return true;
  }

  private function exits($file_name): bool {
    return file_exists($file_name);
  }

  private function convert($valores){
    $csv = "";
    if(is_array($valores)){
      foreach($valores as $valor){
        $csv .= $this->object_to_string($valor);
      }
    }else if( is_object($valores) ){
      $csv .= $this->object_to_string($valores);
    }

    $this->output = $csv;
  }

  private function put_content($file_name, $content_add): bool {
    file_put_contents($file_name, $content_add);
    return true;
  }
  
  private function object_to_string($object){
    $keys = array_keys( get_object_vars($object) );
    sort($keys);
    
    $string = "";
    foreach($keys as $key){

      if(is_object($object->$key)){
        $string .= $this->object_to_string($object->$key);//funcion recursiva;
      }else{
        $string .= $object->$key.",\t";
      }
      
    }
    $string .= "\n";
    return $string;
  }

  public function json_to_csv($file_name){
    $value = $this->get_content($file_name);

    if($value == ""){ return; }

    $value = json_decode($value);
    $this->convert($value);
  }

  public function save_output($ruta){
    $this->put_content( $ruta ,$this->output);
  }
}