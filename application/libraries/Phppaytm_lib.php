<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter PHPMailer Class
 *
 * This class enables SMTP email with PHPMailer
 *
 * @category    Libraries
 * @author      CodexWorld
 * @link        https://www.codexworld.com
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPPaytm_Lib
{
    public function __construct(){
        log_message('Debug', 'PHP Paytm Class loaded.');
    }

    public function load(){
        // Include PHPMailer library files
        require_once APPPATH.'libraries/paytm/PaytmChecksum.php';
        
        
        $paytm = new PaytmChecksum;
        return $paytm;
    }
}