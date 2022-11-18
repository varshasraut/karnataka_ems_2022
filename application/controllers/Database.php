<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Database extends EMS_Controller{
    
   
    
  function __construct(){
           
    parent::__construct();
    $this->load->database();
	$this->active_module = "M-BKUP";
	$this->database = $this->db->database;
	$this->hostname = $this->db->hostname;
	$this->username = $this->db->username;
	$this->password = $this->db->password;
	$this->backup = $this->config->item('backup');
    $this->backup_full_path = $this->config->item('backup_full_path');
	$this->mysql_path = $this->config->item('msql_path');
	$this->load->model('options_model');
    
  }
  
  public function index(){
     
        $data = array();
        $this->output->add_to_position("Config controller loaded");	
     
  }
  
   
    public function auto_backup_generator(){
        
        /*test server*/
        set_time_limit(0);
//        if($_SERVER['SERVER_NAME'] == '172.16.60.243'){
//            $dbhost   = "localhost";
//            $dbuser   = "Sperodev";
//            $dbpwd    = "Jaes!testbySperoDev!Team";
//            $dbname   = "jaemsmp_test_2022";
//        }
//        if($_SERVER['SERVER_NAME'] == '172.16.60.186'){
            /*live server */
            $dbhost   = "localhost";
            $dbuser   = "Admin";
            $dbpwd    = "Jaes!r35XX>!16vwojoq!Admn";
            $dbname   = "jaemsmp_2022";
        //}

        $dumpfile = "/home/jaems/www/JAEms/backup/jaemsmp_2022.sql";

        //system("mysqldump --opt --host=$dbhost --user=$dbuser --password='$dbpwd' $dbname > $dumpfile");
//        echo "mysqldump -u $dbuser -p'$dbpwd' --single-transaction --routines --triggers jaemsmp_2022 > $dumpfile" ;
//        die();
        system("mysqldump -u $dbuser -p'$dbpwd' --single-transaction --routines --triggers jaemsmp_2022 > $dumpfile");
              
        die();
    }
  
    public function generate_backup(){

          $sql_file =$this->backup.'/db_backup/'.date('m').'_'.date('d').'_'.date('Y').'_'.date('H').'_'.date('i').'.sql';


          $cmd = "$this->mysql_path  --opt --host=".$this->hostname." --user=".$this->username." --password=".$this->password."  ". $this->database." > ".$sql_file;

          exec($cmd, $output, $return);


            if ($return != 0) { //0 is ok
               // die('Error: ' . implode("\r\n", $output));
            }
         $this->backup(); 

    }
  
  
    /* Added by MI-42
    *  
    *  This function is used to list backup history.
    */
  
    public function backup(){     

       $data = array();

       $data['files_list'] = glob($this->backup."/*.sql");

       $data['files_list'] = array_combine(array_map("filemtime", $data['files_list']), $data['files_list']);

       krsort($data['files_list']);

       $data['last_download_details'] = unserialize($this->options_model->get_option("ms_last_backup"));

       $data['total_downloads']=count($data['files_list']);

       $this->output->add_to_position($this->load->view('frontend/database/database_list_view',$data,true));

     }
  
  
    /* Added by MI-42
    *  
    *  This function is used delete backup.
    */
  
    public function delete(){


          $file_name = $this->input->post('filename');

          if(is_array($file_name)){

              foreach($file_name as $files){

                 $fname = base64_decode($files);
                 $delete_files = unlink($fname);

              }
         }

              if($this->input->get('filename')){
                        $fname = base64_decode($this->input->get('filename'));
                        $delete_files = unlink($fname);
              }else{

                  $this->output->message = "<div class='error'>Please select file</div>";

              }
              if($delete_files == true){   

                      $this->backup(); 
                      $this->output->status = 1;
                      $this->output->message =  "<div class='success'>files Deleted Successfully!</div>";

              }else{

                      $this->output->message =  "<div class='error'>Please Select at least One Record</div>"; 
              }

     }
     
    /* Added by MI-42
    *  
    *  This function is used download backup.
    */
   
    public function download_backup($name){

              $file = base64_decode(urldecode($name));

              $last_records = array(
                                    'filename' => $file ,
                                    'time'   => date('Y-m-d h:i:s A'),
                                    'download_by' =>$this->session->userdata('current_user')->clg_ref_id
              );

              $result = $this->options_model->add_option("ms_last_backup",  serialize($last_records));

              if($result){
              if(function_exists('finfo_open')){
                   $finfo = finfo_open(FILEINFO_MIME_TYPE);

                   $content_type = finfo_file($finfo, $file);

                   finfo_close($finfo);
              }
              else if(function_exists('mime_content_type')){

                  $content_type = mime_content_type($file);

              }
              else{

                  $content_type = "application/octet-stream";

              }

              if (file_exists($file)) {
                  header('Content-Description: File Download');
                  header('Content-Type: '.$content_type);
                  header('Content-Disposition: attachment; filename='.basename($file));
                  header('Content-Transfer-Encoding: binary');
                  header('Expires: 0');
                  header('Cache-Control: must-revalidate');
                  header('Pragma: public');
                  header('Content-Length: ' . filesize($file));
                  ob_clean();
                  flush();
                  readfile($file);
                  exit;
              }
             die();
              }
              else{

                  $this->output->message = "<div class='error'>Filed to get backup!!</div>";
              }

        }
       
    public function delete_database(){
        
    }    
}