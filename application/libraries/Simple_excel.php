<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

 require_once( APPPATH . 'libraries/simple_excel/SimpleExcel.php' );
 
class Simple_excel{  

    function __construct ( $options = array() )
    {
      
        require_once( APPPATH . 'libraries/simple_excel/SimpleExcel.php' );
    }

    public function __get( $var ) { return get_instance()->$var; }
}