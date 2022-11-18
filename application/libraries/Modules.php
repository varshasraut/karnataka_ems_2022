<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Modules {

    var $toolbar;
    public $reserved_selectors = array('click-xhttp-request', 'change-xhttp-request', 'change-base-xhttp-request', 'form-xhttp-request', 'base-xhttp-request', 'onpage_popup');

    // connect to the server and get the inbox emails

    function __construct() {





        if (class_exists('CI_Controller')) {



            $this->CI->load->library('session');

            $this->CI->load->model('env/modules_model');

            $this->base_url = $this->CI->config->item('base_url');




            $this->current_user = $this->CI->session->userdata('current_user');
        }
    }

    function __get($var) {

        if ($var == "CI") {

            return get_instance();
        } else {

            return $var;
        }
    }

    public function check_module_permission() {



        if (!$this->CI->active_module || !array_key_exists($this->CI->active_module, $this->current_user->modules)) {

            $this->CI->session->set_flashdata('warning', 'You does not have permission to access this section!');

            header("location: " . $_SERVER[HTTP_REFERER]);

            die();
        }
    }

    public function get_module($mcode) {

        if ($mcode) {

            return $this->current_user->modules[$mcode];
        }
    }

    public function load_modulebar($loadtools = false) {



        if (!$this->CI->session->userdata('user_logged_in')) {
            return false;
        }
          if (!$this->CI->session->userdata('current_user')) {
            return false;
        }



        $this->current_user->modules = $this->CI->modules_model->get_group_modules(trim($this->current_user->clg_group));



        if (!$this->current_user->modules) {
            return false;
        }



        if ($loadtools) {

            $this->load_toolbar();
        }

        //$this->check_module_permission();

        if (is_array($this->current_user->modules)) {

            foreach ($this->current_user->modules as $mcode => $module) {

                $module->module = str_replace(" ", "", strtolower($module->module));

                $this->CI->modulebar[$module->module] = $this->get_module_action($module);

                if ($loadtools) {
                    @$this->CI->modulebar[$module->module] .= "<ul><li>" . join("</li><li>", $this->toolbar[$module->module]['TAB-LINK']) . "</li></ul>";
                }
            }
        }
//                   var_dump($this->CI->modulebar);exit;
    }

    public function get_module_action($module) {

        if (!$this->current_user) {
            return false;
        }

        if (!$module) {
            return false;
        }

        if ($module->m_type == 'http') {



            $action = "<a href='$module->url'  class='" . $module->module . "_ico mitooltip' tip='$module->module' ><span id='" . $module->module . "_cnt' class='cnt' >0</span></a>";
        } else if ($module->is_alias != '1') {



            $query_string = array();

            ///  $query_string['output_position'] = $module->module."_position"; //content

            $query_string['output_position'] = "content"; //content

            $query_string['module_name'] = $module->module;



            $query_string_opt = parse_str($module->m_query_string, $qr);



            if (is_array($qr)) {

                foreach ($qr as $key => $val) {

                    $query_string[$key] = $val;
                }
            }



            $module->m_query_string = http_build_query($query_string);



//				   $module->m_query_string = trim(trim($module->m_query_string,"&")."&output_position=".$module->module."_position&module_name=".$module->module,"&");
            // $action = "<a href='$module->url'  class='".$module->module."_ico mitooltip  click-xhttp-request' tip='$module->module' data-qr='$module->m_query_string' >".ucwords($module->module_name)."</a>";  


            $action = "<a href='#'  class='" . $module->module . "_ico mitooltip ' tip='$module->module' data-index=''  >" . ucwords($module->module_name) . "</a>";


//var_dump($action);
        }



        return $action;
    }

    public function load_toolbar() {



        if (!$this->CI->session->userdata('user_logged_in')) {
            return false;
        }



        // $this->check_module_permission();

        if (!@$this->current_user->permited_tools) {

            $this->current_user->permited_tools = $this->CI->modules_model->get_group_tools(trim($this->current_user->clg_group));
        }

        

        if (is_array($this->current_user->permited_tools)) {



            foreach ($this->current_user->permited_tools as $module_code => $module) {


                $module_details = $this->current_user->modules[$module_code];

                if ($module_details->module != "") {

                    $module_details->module = str_replace(" ", "", strtolower($module_details->module));
                }


                foreach ($module as $tcode => $tool) {


                    $this->toolbar[$module_details->module][$tool->tl_display_type][$tcode] = $this->get_tool_action($tool);
                }
            }

            /// echo "<pre>";
            $this->CI->session->set_userdata('toolbar', $this->toolbar);
            ///var_dump($this->CI->toolbar);exit;
        }
    }

    public function get_tool_action($tool, $module = "", $flag = false) {



        if (!$this->current_user) {
            return false;
        }

        if (!$tool) {
            return false;
        }



        if ($flag) {

            if ($module != "") {

                $tool = $this->current_user->permited_tools[$module][$tool];
            } else {
                return false;
            }
        }



        $tool->tlcode = str_replace("-", "_", strtolower($tool->tlcode));











        // $qr["output_position"] = $tool->tlcode."_position";

        $qr["output_position"] = "content";



        $qr["tool_code"] = $tool->tlcode;









        parse_str($tool->tl_query_string, $dqr);



        $tl_query_string = http_build_query(array_merge($qr, $dqr));


        
        if ($tool->is_alias == '0') {


            if (trim($tool->tl_display_type) == 'TAB-LINK') {


                if ($tool->tl_type == 'http') {

                    $action = "<a class='$tool->tlcode' href='$tool->tl_url' >$tool->tl_name</a>";
                } else {



                    $action = "<a class=\"$tool->tlcode  click-xhttp-request\" href=\"$tool->tl_url\" data-qr=\"$tl_query_string\" %s >$tool->tl_name</a>";
                }
            } else if (trim($tool->tl_display_type) == 'PAGE-LINK') {



                if ($tool->tl_type == 'http') {

                    $action = "<a class='$tool->tlcode' href='$tool->tl_url'  >$tool->tl_name</a>";
                } else {

                    $action = "<a class=\"$tool->tlcode %s\" href=\"$tool->tl_url%s\" data-qr=\"$tl_query_string\" %s >$tool->tl_name</a>";
                }
            } else if (trim($tool->tl_display_type) == 'PAGE-BUTTON') {



                $action = "<input type='button' name='$tool->tlcode' class=\"$tool->tlcode %s\" data-href=\"$tool->tl_url%s\" data-qr=\"$tl_query_string\" value='$tool->tl_name' %s >";
            }
        }

        return $action;
    }

    public function get_tool_html($tool, $module_code, $class = "click-xhttp-request", $add_qr = "", $add_data = "") {



        if (!$this->current_user) {
            return false;
        }

        if (!$tool) {
            return false;
        }

        $html = "";



        if ($class && count(array_intersect($this->reserved_selectors, explode(" ", $class))) <= 0) {

            $class = "click-xhttp-request " . $class;
        }

        $module_details = $this->current_user->modules[$module_code];


        $module_details->module = str_replace(" ", "", strtolower($module_details->module));
///var_dump($module_details->module);
///var_dump($this->CI);   			   
        $this->toolbar = $this->CI->session->userdata('toolbar');
        if (is_array($this->toolbar[$module_details->module])) {





            foreach ($this->toolbar[$module_details->module] as $key => $val) {



                if (is_array($this->toolbar[$module_details->module][$key]) && @$this->toolbar[$module_details->module][$key][$tool] != "") {

                    $html = sprintf($this->toolbar[$module_details->module][$key][$tool], $class, $add_qr, $add_data);


                    break;
                }
            }
        }





        return $html;
    }

    public function get_tool_config($tool, $module = "", $flag = false) {







        if (!$this->current_user) {
            return false;
        }

        if (!$tool) {
            return false;
        }

        $config = array();



        if ($flag) {

            if ($module != "") {


                $tool = @$this->current_user->permited_tools[trim($module)][trim($tool)];
            } else {
                return false;
            }
        }



        if (!$tool) {
            return false;
        }



        $config["href"] = $tool->tl_url;



        if ($tool->tl_type == 'http') {

            $config["qr"] = "";
        } else {

            @$tool->tlcode = str_replace("-", "_", strtolower($tool->tlcode));





            $default_qr ["output_position"] = "content";

            $default_qr ["tool_code"] = $tool->tlcode;

            parse_str(trim($tool->tl_query_string, "&"), $qr);



            if (is_array($qr)) {
                $qr = array_merge($default_qr, $qr);
            }



            $config["qr"] = http_build_query($qr);

            //$config["qr"]= trim(trim($tool->tl_query_string ,"&")."&output_position=".$tool->tlcode."_position&tool_code=".$tool->tlcode,"&");
        }



        return $config;
    }

    public function index() {
        
    }

}

?>