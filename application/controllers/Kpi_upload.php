<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Kpi_Upload extends EMS_Controller {

    function __construct() {

        parent::__construct();

        $this->active_module = "M-UPLOAD-DASH";

        $this->pg_limit = $this->config->item('pagination_limit');

        $this->load->model(array('kpi_dashboard_model'));

        $this->load->helper(array('form', 'url', 'cookie', 'string', 'date', 'comman_helper'));

        $this->load->library(array('form_validation', 'encrypt', 'image_lib', 'session', 'email', 'upload', 'modules'));

        $this->post = $this->input->get_post(NULL);

        $this->clg = $this->session->userdata('current_user');
    }

    public function index($generated = false) {
        echo "This is  controller";
    }

    function upload_kpi_dash(){
  
        $this->output->add_to_position($this->load->view('kpi_dashboard/upload_kpi_dash_view', $data, TRUE), 'content', TRUE);    }

        function download_sample_format()
        {
            $header = array(
            'Call_Center_KPI_I_Total_Calls_Answered_by_Agent',
            'Call_Center_KPI_I_Calls_Answered_by_Agent(<=12 Seconds)',
            'Call_Center_KPI_I_Calls_Answered_by_Agent(> 12 Seconds)',
            'Call_Center_KPI_II_Total_Calls_Offered',
            'Call_Center_KPI_II_Total_Calls_of_Abandoned',
            'Call_Center_KPI_II_Total_Hours',
            'Call_Center_KPI_III_ERC_Uptime_Hours',
            'Call_Center_KPI_III_ERC_Downtime_Hours',
            'Sanjeevani_108_KPI_I_Compliance_Benchmark',
            'Sanjeevani_108_KPI_I_Date',
            'Sanjeevani_108_KPI_I_Month',
            'Sanjeevani_108_KPI_I_ALS_Deployment_As_per_RFP',
            'Sanjeevani_108_KPI_I_BLS_Deployment_As_per_RFP',
            'Sanjeevani_108_KPI_I_ALS_Deployed',
            'Sanjeevani_108_KPI_I_BLS_Deployed',
            'Sanjeevani_108_KPI_II_Compliance_Benchmark',
            'Sanjeevani_108_KPI_II_Total_Served_Cases_Urban',
            'Sanjeevani_108_KPI_II_Response_Time_Urban',
            'Sanjeevani_108_KPI_II_Total_Served_Cases_Rural',
            'Sanjeevani_108_KPI_II_Response_Time_Rural',
            'Sanjeevani_108_KPI_III_Compliance_Benchmark',
            'Sanjeevani_108_KPI_III_Total_Ambulance_(A)',
            'Sanjeevani_108_KPI_III_Total_Ambulance_(A)_percentage',
            'Sanjeevani_108_KPI_III_Total_Ambulance_On_Road_(B)',
            'Sanjeevani_108_KPI_III_Total_Ambulance_On_Road_(B)_percentage',
            'Sanjeevani_108_KPI_III_Total_Ambulance_Off_Road_for_More_than_24_Hrs_(C)',
            'Sanjeevani_108_KPI_III_Total_Ambulance_Off_Road_for_More_than_24_Hrs_(C)_percentage',
            'Sanjeevani_108_KPI_III_Total_Ambulance_Off_Road',
            'Sanjeevani_108_KPI_III_Total_Ambulance_Off_Road_percentage',
            'Sanjeevani_108_KPI_IV_Compliance_Benchmark',
            'Sanjeevani_108_KPI_IV_Total_Ambulance_(A)',
            'Sanjeevani_108_KPI_IV_Total_Ambulance_(A)_percentage',
            'Sanjeevani_108_KPI_IV_Total_Ambulance_On_Road_(B)',
            'Sanjeevani_108_KPI_IV_Total_Ambulance_On_Road_(B)_percentage',
            'Sanjeevani_108_KPI_IV_Total_Ambulance_Off_Road_for_More_than_60_Hours_(C)',
            'Sanjeevani_108_KPI_IV_Total_Ambulance_Off_Road_for_More_than_60_Hours_(C)_percentage',
            'Sanjeevani_108_KPI-IV_Total_Ambulance_(D)',
            'Sanjeevani_108_KPI-IV_Total_Ambulance_(D)_percentage',
            'Sanjeevani_108_KPI_V_Compliance_Benchmark',
            'Sanjeevani_108_KPI_V_Total_Ambulance_GPS_Devices_(A)',
            'Sanjeevani_108_KPI_V_Total_Ambulance_GPS_Functioning_(B)',
            'Sanjeevani_108_KPI_V_Total_Ambulance_GPS_Device_Non_Functioning_(C)',
            'Sanjeevani_108_KPI_V.1_Compliance_Benchmark',
            'Sanjeevani_108_KPI_V.1_Total_Ambulance_MDT_Devices_(A)',
            'Sanjeevani_108_KPI_V.1_Total_Ambulance_MDT_Functioning_(B)',
            'Sanjeevani_108_KPI_V.1_Total_Ambulance_MDT_Device_Non_Functioning_(C)',
            'Sanjeevani_108_KPI_VI_Compliance_Benchmark',
            'Sanjeevani_108_KPI_VI_Total_Ambulance_Inspected_(A)',
            'Sanjeevani_108_KPI_VI_Total_Ambulance_Audit_non_Compliance_(B)',
            'Sanjeevani_108_KPI_VII_Compliance_Benchmark',
            'Sanjeevani_108_KPI_VII_Total_Not_Availed_Cases_(A)_Rural',
            'Sanjeevani_108_KPI_VII_Total_Not_Availed_Cases_with_in_<=_Response_Time_(B)_Rural',
            'Sanjeevani_108_KPI_VII_Total_Not_Availed_Cases_with_in_>_Response_Time_(C)_Rural',
            'Sanjeevani_108_KPI_VII_Total_Not_Availed_Cases_(A)_Urban',
            'Sanjeevani_108_KPI_VII_Total_Not_Availed_Cases_with_in_<=_Response_Time_(B)_Urban',
            'Sanjeevani_108_KPI_VII_Total_Not_Availed_Cases_with_in_>_Response_Time_(C)_Urban',
            'Sanjeevani_108_KPI_VIII_Compliance_Benchmark',
            'Sanjeevani_108_KPI_VIII_Total_Count_of_Ambulances_Equipments_(A)',
            'Sanjeevani_108_KPI_VIII_Total_Count_of_Ambulances_Equipments_Available_(B)',
            'Sanjeevani_108_KPI_VIII_Total_Count_of_Ambulances_Equipments_Not_Available_(C)',
            'Sanjeevani_108_KPI_VIII_Sum_of_Total_Number_of_Days_Ambulance_Equipment_Not_Available_in_Days_(D)',
            'Janani_Express_KPI_I_Compliance_Benchmark',
            'Janani_Express_KPI_I_Month',
            'Janani_Express_KPI_I_JSSK_Deployed_As_Per_PRF',
            'Janani_Express_KPI_I_JSSK_Deployed',
            'Janani_Express_KPI_I_Remark',
            'Janani_Express_KPI_II_Compliance_Benchmark',
            'Janani_Express_KPI_II_Total_Served_Cases_Urban',
            'Janani_Express_KPI_II_Response_Time_Urban',
            'Janani_Express_KPI_II_Total_Served_Cases_Rural',
            'Janani_Express_KPI_II_Response_Time_Rural',
            'Janani_Express_KPI_III_Compliance_Benchmark',
            'Janani_Express_KPI_III_Total_Ambulance_(A)',
            'Janani_Express_KPI_III_Total_Ambulance_(A)_percentage',
            'Janani_Express_KPI_III_Total_Ambulance_On_Road_(B)',
            'Janani_Express_KPI_III_Total_Ambulance_On_Road_(B)_percentage',
            'Janani_Express_KPI_III_Total_Ambulance_Off_Road_for_More_Than_24_Hrs_(C)',
            'Janani_Express_KPI_III_Total_Ambulance_Off_Road_for_More_Than_24_Hrs_(C)_percentage',
            'Janani_Express_KPI_III_Total_Ambulance_Off_Road',
            'Janani_Express_KPI_III_Total_Ambulance_Off_Road_percentage',
            'Janani_Express_KPI_IV_Compliance_Benchmark',
            'Janani_Express_KPI_IV_Total_Ambulance_(A)',
            'Janani_Express_KPI_IV_Total_Ambulance_(A)_percentage',
            'Janani_Express_KPI_IV_Total_Ambulance_On_Road_(B)',
            'Janani_Express_KPI_IV_Total_Ambulance_On_Road_(B)_percentage',
            'Janani_Express_KPI_IV_Total_Ambulance_Off_Road_for_More_Than_60_Hrs_(C)',
            'Janani_Express_KPI_IV_Total_Ambulance_Off_Road_for_More_Than_60_Hrs_(C)_percentage',
            'Janani_Express_KPI_IV_Total_Ambulance_(D)',
            'Janani_Express_KPI_IV_Total_Ambulance_(D)_percentage',
            'Janani_Express_KPI_V_Compliance_Benchmark',
            'Janani_Express_KPI_V_Total_Ambulance_GPS_Devices_(A)',
            'Janani_Express_KPI_V_Total_Ambulance_GPS_Functioning_(B)',
            'Janani_Express_KPI_V_Total_Ambulance_GPS_Device_Non_Functioning_(C)',
            'Janani_Express_KPI_V.1_Compliance_Benchmark',
            'Janani_Express_KPI_V.1_Total_Ambulance_MDT_Devices_(A)',
            'Janani_Express_KPI_V.1_Total_Ambulance_MDT_Functioning_(B)',
            'Janani_Express_KPI_V.1_Total_Ambulance_MDT_Device_Non_Functioning_(C)',
            'Janani_Express_KPI_VI_Compliance_Benchmark',
            'Janani_Express_KPI_VI_Total_Ambulance_Inspected_(A)',
            'Janani_Express_KPI_VI_Total_Ambulance_Audit_non_Compliance_(B)',
            'Janani_Express_KPI_VII_Compliance_Benchmark',
            'Janani_Express_KPI_VII_Total_Not_Availed_Cases_(A)_Rural',
            'Janani_Express_KPI_VII_Total_Not_Availed_Cases_with_in_<=_Response_Time_(B)_Rural',
            'Janani_Express_KPI_VII_Total_Not_Availed_Cases_with_in_>_Response_Time_(C)_Rural',
            'Janani_Express_KPI_VII_Total_Not_Availed_Cases_(A)_Urban',
            'Janani_Express_KPI_VII_Total_Not_Availed_Cases_with_in_<=_Response_Time_(B)_Urban',
            'Janani_Express_KPI_VII_Total_Not_Availed_Cases_with_in_>_Response_Time_(C)_Urban',
            '104_Health_Helpline_KPI_I_Compliance_Benchmark',
            '104_Health_Helpline_KPI_I_Total_Ambulance_(A)',
            '104_Health_Helpline_KPI_I_Total_Ambulance_(A)_percentage',
            '104_Health_Helpline_KPI_I_Calls_Answered_by_Agent_(<=12 Seconds)',
            '104_Health_Helpline_KPI_I_Calls_Answered_by_Agent_(<=12 Seconds)_percentage',
            '104_Health_Helpline_KPI_I_Calls_Answered_by_Agent_(> 12 Seconds)',
            '104_Health_Helpline_KPI_I_Calls_Answered_by_Agent_(> 12 Seconds)_percentage',
            '104_Health_Helpline_KPI_II_Compliance_Benchmark',
            '104_Health_Helpline_KPI_II_Total_Calls_Offered',
            '104_Health_Helpline_KPI_II_Total_Calls_Offered_percentage',
            '104_Health_Helpline_KPI_II_Total_Calls_of_Abandoned',
            '104_Health_Helpline_KPI_II_Total_Calls_of_Abandoned_percentage',
            '104_Health_Helpline_KPI_III_Compliance_Benchmark',
            '104_Health_Helpline_KPI_III_Total_hours',
            '104_Health_Helpline_KPI_III_ERC_Uptime_Hours',
            '104_Health_Helpline_KPI_III_ERC_Downtime_Hours',
            '104_Health_Helpline_KPI_IV_Compliance_Benchmark',
            '104_Health_Helpline_KPI_IV_NHM_Manpower_Target_Team_Lead',
            '104_Health_Helpline_KPI_IV_NHM_Manpower_Target_Doctors',
            '104_Health_Helpline_KPI_IV_NHM_Manpower_Target_Clinical_Psychologists_(CP)',
            '104_Health_Helpline_KPI_IV_NHM_Manpower_Target_Paramedic',
            '104_Health_Helpline_KPI_IV_NHM_Manpower_Target_Total',
            '104_Health_Helpline_KPI_IV_JAES_Manpowert_Team_Lead',
            '104_Health_Helpline_KPI_IV_JAES_Manpower_Doctors',
            '104_Health_Helpline_KPI_IV_JAES_Manpower_Clinical_Psychologists_(CP)',
            '104_Health_Helpline_KPI_IV_JAES_Manpowert_Paramedic',
            '104_Health_Helpline_KPI_IV_JAES_Manpower_Total'
            );
            $filename = "KPI_Data_Import_format.csv";
            $fp = fopen('php://output', 'w');
    
            header('Content-type: application/csv; charset=UTF-8');
            header('Content-Disposition: attachment; filename=' . $filename);
            fputcsv($fp, $header);
            $data = array( );
            fputcsv($fp, $data);
            fclose($fp);
            exit;
        }
        function save_import_kpi_dash()
        {
            $post_data = $this->input->post();
            $filename = $_FILES["file"]["tmp_name"];
    
            if ($_FILES["file"]["size"] > 0) {
                $file = fopen($filename, "r");
            
                while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                    $column_count = count($getData);
                    // var_dump($column_count);die();
                    if ($column_count == 134) {
                        if ($count == 0) {
                            $count++;
                            continue;
                        } else {
                           
                            $kpi_data = array(
                                'cc_kpi1_tcaa'=>$getData[0],
                                'cc_kpi1_caa_less_12_sec'=>$getData[1],
                                'cc_kpi1_caa_more_12_sec'=>$getData[2],
                                'cc_kpi2_tco'=>$getData[3],
                                'cc_kpi2_tca'=>$getData[4],
                                'cc_kpi3_total_hrs'=>$getData[5],
                                'cc_kpi3_erc_up'=>$getData[6],
                                'cc_kpi3_erc_down'=>$getData[7],
                                'sj_kpi1_cb'=>$getData[8],
                                'sj_kpi1_date'=>date('Y-m-d',strtotime($getData[9])),
                                'sj_kpi1_month'=>$getData[10],
                                'sj_kpi1_als_deploy_rfp'=>$getData[11],
                                'sj_kpi1_bls_deploy_rfp'=>$getData[12],
                                'sj_kpi1_als_deployed'=>$getData[13],
                                'sj_kpi1_bls_deployed'=>$getData[14],
                                'sj_kpi2_cb'=>$getData[15],
                                'sj_kpi2_tcs_urban'=>$getData[16],
                                'sj_kpi2_res_time_urban'=>$getData[17],
                                'sj_kpi2_tcs_rural'=>$getData[18],
                                'sj_kpi2_res_time_rural'=>$getData[19],
                                'sj_kpi3_cb'=>$getData[20],
                                'sj_kpi3_ta_A'=>$getData[21],
                                'sj_kpi3_ta_A_perc'=>$getData[22],
                                'sj_kpi3_ta_onroad_B'=>$getData[23],
                                'sj_kpi3_ta_onroad_B_perc'=>$getData[24],
                                'sj_kpi3_ta_offroad_more_24hrs_C'=>$getData[25],
                                'sj_kpi3_ta_offroad_more_24hrs_C_perc'=>$getData[26],
                                'sj_kpi3_ta_offroad'=>$getData[27],
                                'sj_kpi3_ta_offroad_perc'=>$getData[28],
                                'sj_kpi4_cb'=>$getData[29],
                                'sj_kpi4_ta_A'=>$getData[30],
                                'sj_kpi4_ta_A_perc'=>$getData[31],
                                'sj_kpi4_ta_onroad_B'=>$getData[32],
                                'sj_kpi4_ta_onroad_B_perc'=>$getData[33],
                                'sj_kpi4_ta_offroad_more_60hrs_C'=>$getData[34],
                                'sj_kpi4_ta_offroad_more_60hrs_C_perc'=>$getData[35],
                                'sj_kpi4_ta_D'=>$getData[36],
                                'sj_kpi4_ta_D_perc'=>$getData[37],
                                'sj_kpi5_cb'=>$getData[38],
                                'sj_kpi5_ta_gps_device_A'=>$getData[39],
                                'sj_kpi5_ta_gps_functn_B'=>$getData[40],
                                'sj_kpi5_ta_gps_device_non_functn_C'=>$getData[41],
                                'sj_kpi5_1_cb'=>$getData[42],
                                'sj_kpi5_1_ta_mdt_device_A'=>$getData[43],
                                'sj_kpi5_1_ta_mdt_functn_B'=>$getData[44],
                                'sj_kpi5_1_ta_mdt_device_non_functn_C'=>$getData[45],
                                'sj_kpi6_cb'=>$getData[46],
                                'sj_kpi6_ta_inspect_A'=>$getData[47],
                                'sj_kpi6_ta_audit_B'=>$getData[48],
                                'sj_kpi7_cb'=>$getData[49],
                                'sj_kpi7_tnac_A_rural'=>$getData[50],
                                'sj_kpi7_tnac_less_res_time_B_rural'=>$getData[51],
                                'sj_kpi7_tnac_more_res_time_C_rural'=>$getData[52],
                                'sj_kpi7_tnac_A_urban'=>$getData[53],
                                'sj_kpi7_tnac_less_res_time_B_urban'=>$getData[54],
                                'sj_kpi7_tnac_more_res_time_C_urban'=>$getData[55],
                                'sj_kpi8_cb'=>$getData[56],
                                'sj_kpi8_tc_amb_equip_A'=>$getData[57],
                                'sj_kpi8_tc_amb_equip_avail_B'=>$getData[58],
                                'sj_kpi8_tc_amb_equip_not_avail_C'=>$getData[59],
                                'sj_kpi8_tn_days_amb_equip_not_avail_D'=>$getData[60],
                                'je_kpi1_cb'=>$getData[61],
                                'je_kpi1_month'=>$getData[62],
                                'je_kpi1_jssk_deployed_prf'=>$getData[63],
                                'je_kpi1_jssk_deployed'=>$getData[64],
                                'je_kpi1_remark'=>$getData[65],
                                'je_kpi2_cb'=>$getData[66],
                                'je_kpi2_tcs_urban'=>$getData[67],
                                'je_kpi2_res_time_urban'=>$getData[68],
                                'je_kpi2_tcs_rural'=>$getData[69],
                                'je_kpi2_res_time_rural'=>$getData[70],
                                'je_kpi3_cb'=>$getData[71],
                                'je_kpi3_ta_A'=>$getData[72],
                                'je_kpi3_ta_A_perc'=>$getData[73],
                                'je_kpi3_ta_onroad_B'=>$getData[74],
                                'je_kpi3_ta_onroad_B_perc'=>$getData[75],
                                'je_kpi3_ta_offroad_more_24hrs_C'=>$getData[76],
                                'je_kpi3_ta_offroad_more_24hrs_C_perc'=>$getData[77],
                                'je_kpi3_ta_offroad'=>$getData[78],
                                'je_kpi3_ta_offroad_perc'=>$getData[79],
                                'je_kpi4_cb'=>$getData[80],
                                'je_kpi4_ta_A'=>$getData[81],
                                'je_kpi4_ta_A_perc'=>$getData[82],
                                'je_kpi4_ta_onroad_B'=>$getData[83],
                                'je_kpi4_ta_onroad_B_perc'=>$getData[84],
                                'je_kpi4_ta_offroad_more_60hrs_C'=>$getData[85],
                                'je_kpi4_ta_offroad_more_60hrs_C_perc'=>$getData[86],
                                'je_kpi4_ta_D'=>$getData[87],
                                'je_kpi4_ta_D_perc'=>$getData[88],
                                'je_kpi5_cb'=>$getData[89],
                                'je_kpi5_ta_gps_device_A'=>$getData[90],
                                'je_kpi5_ta_gps_functn_B'=>$getData[91],
                                'je_kpi5_ta_gps_device_non_functn_C'=>$getData[92],
                                'je_kpi5_1_cb'=>$getData[93],
                                'je_kpi5_1_ta_mdt_device_A'=>$getData[94],
                                'je_kpi5_1_ta_mdt_functn_B'=>$getData[95],
                                'je_kpi5_1_ta_mdt_device_non_functn_C'=>$getData[96],
                                'je_kpi6_cb'=>$getData[97],
                                'je_kpi6_ta_inspect_A'=>$getData[98],
                                'je_kpi6_ta_audit_B'=>$getData[99],
                                'je_kpi7_cb'=>$getData[100],
                                'je_kpi7_tnac_A_rural'=>$getData[101],
                                'je_kpi7_tnac_less_res_time_B_rural'=>$getData[102],
                                'je_kpi7_tnac_more_res_time_C_rural'=>$getData[103],
                                'je_kpi7_tnac_A_urban'=>$getData[104],
                                'je_kpi7_tnac_less_res_time_B_urban'=>$getData[105],
                                'je_kpi7_tnac_more_res_time_C_urban'=>$getData[106],
                                'hh_104_kpi1_cb'=>$getData[107],
                                'hh_104_kpi1_ta_A'=>$getData[108],
                                'hh_104_kpi1_ta_A_perc'=>$getData[109],
                                'hh_104_kpi1_caa_less_12_sec'=>$getData[110],
                                'hh_104_kpi1_caa_less_12_sec_perc'=>$getData[111],
                                'hh_104_kpi1_caa_more_12_sec'=>$getData[112],
                                'hh_104_kpi1_caa_more_12_sec_perc'=>$getData[113],
                                'hh_104_kpi2_cb'=>$getData[114],
                                'hh_104_kpi2_tco'=>$getData[115],
                                'hh_104_kpi2_tco_perc'=>$getData[116],
                                'hh_104_kpi2_tca'=>$getData[117],
                                'hh_104_kpi2_tca_perc'=>$getData[118],
                                'hh_104_kpi3_cb'=>$getData[119],
                                'hh_104_kpi3_total_hrs'=>$getData[120],
                                'hh_104_kpi3_erc_uptime'=>$getData[121],
                                'hh_104_kpi3_erc_downtime'=>$getData[122],
                                'hh_104_kpi4_cb'=>$getData[123],
                                'hh_104_kpi4_nhm_tl'=>$getData[124],
                                'hh_104_kpi4_nhm_doc'=>$getData[125],
                                'hh_104_kpi4_nhm_cp'=>$getData[126],
                                'hh_104_kpi4_nhm_paramedic'=>$getData[127],
                                'hh_104_kpi4_nhm_total'=>$getData[128],
                                'hh_104_kpi4_jaes_tl'=>$getData[129],
                                'hh_104_kpi4_jaes_doc'=>$getData[130],
                                'hh_104_kpi4_jaes_cp'=>$getData[131],
                                'hh_104_kpi4_jaes_paramedic'=>$getData[132],
                                'hh_104_kpi4_jaes_total'=>$getData[133],
                            );
                            // print_r($kpi_data);die;
                            $insert = $this->kpi_dashboard_model->insert_kpi_data($kpi_data);
                               
                        }
                        }
                     else {
                        $this->output->message = "<div class='error'>" . "CSV column count not match" . "</div>";
                    }
                }
                if(!empty($kpi_data)){
                    $this->output->status = 1;
                    $this->output->message = "<div class='success'>" . "Dashboard Details is added successfully" . "</div>";
                    $this->output->closepopup = 'yes';
                    $this->output->status = 1;
                }
            }
        }
        
        // function get_kpi_data(){

        //     $data = $this->kpi_dashboard_model->get_kpi_data();
        //     // print_r($data);die;
        // }
}
    ?>