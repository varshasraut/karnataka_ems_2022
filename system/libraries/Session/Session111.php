<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Session Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Sessions
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/sessions.html
 */
class CI_Session {

    public function __construct()
    {
      ////  session_set_cookie_params(0, '/'); 
       //// session_regenerate_id(true);
      ///  $ok = @session_start();
        /*
if(!$ok){
session_regenerate_id(true); // replace the Session ID
session_start(); 
}*/
        
        $this->keep_session_alive();
    }
    
    
    public function keep_session_alive() {

        $sessionCookieExpireTime = 25 * 60 * 60; // 10 hours

        ini_set('session.gc_maxlifetime', $sessionCookieExpireTime);

        ini_set('session.gc_probability', 1);

        ini_set('session.gc_divisor', 1);

        session_set_cookie_params($sessionCookieExpireTime);

        @session_start();

        if (isset($_COOKIE[session_name()]))
            setcookie(session_name(), $_COOKIE[session_name()], time() + $sessionCookieExpireTime, "/");
    }
    
	static public function all_userdata(){
	   return $_SESSION;
	
	}

    public function set_userdata( $key, $value ){
        $_SESSION[$key] = $value;
    }
    
    public function set_flashdata( $key, $value ){
		$_SESSION['flashdata'][$key] = $value;
		
    }
	
	public function tempdata( $key ){
        return isset( $_SESSION['flashdata'][$key] ) ? $_SESSION['flashdata'][$key] : null;
    }

	
	 public function set_tempdata( $key, $value = NULL, $ttl = 300){
		$_SESSION['flashdata'][$key] = $value;
		
    }
	
	public function unset_tempdata($key){
	    
        unset($_SESSION['flashdata'][$key] );	
    }

    public function flashdata( $key ){
		$val = isset( $_SESSION['flashdata'][$key] ) ? $_SESSION['flashdata'][$key] : null;
        
		return $val;
    }

    public function unset_userdata($key){
	    unset($_SESSION[$key] );	
        unset($_SESSION['flashdata'][$key] );	
    }
	
	public function get_userdata($key="")
	{
		return $_SESSION;
	}
	
    public function userdata( $key ){
        return isset( $_SESSION[$key] ) ? $_SESSION[$key] : null;
    }

    public function regenerateId( $delOld = false ){
        session_regenerate_id( $delOld );
    }

    public function delete( $key ){
        unset( $_SESSION[$key] );
    }
	
    public function sess_destroy(){
       session_destroy();	
    }
	
}

// END Session Class

/* End of file Session.php */
/* Location: ./system/libraries/Session.php */