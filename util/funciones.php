<?php

function data_submitted() {
    $_AAux= array();
    if (!empty($_POST))
        $_AAux =$_POST;
    else
        if(!empty($_GET)) {
            $_AAux =$_GET;
        }
    if (count($_AAux)){
        foreach ($_AAux as $indice => $valor) {
            if ($valor=="")
                $_AAux[$indice] = 'null'	;
        }
    }
    return $_AAux;
}

// auto load register 
spl_autoload_register(function ($class_name){
    //echo($class_name);
    //echo($_SESSION['ROOT']); 
    $directorys = array(
        $GLOBALS['ROOT'].'Modelo/',
        $GLOBALS['ROOT'].'Modelo/conector/',
        $GLOBALS['ROOT'].'Control/',
        $GLOBALS['ROOT'].'Vista/'
      //  $GLOBALS['ROOT'].'util/class/',
        );
    //print_r($directorys) ;
    foreach($directorys as $directory){

        if(file_exists($directory.$class_name .'.php')){
            // echo "se incluyo".$directory.$class_name . '.php';
            require_once($directory.$class_name .'.php');
            return;
        }
    }
});

?>