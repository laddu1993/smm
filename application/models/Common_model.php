<?php
error_reporting(0);
//ini_set("display_errors",1);
/**
 *
 * @package    Common_model
 * @author     Vinil Lakkavatri (vinil.lakkavatri@icloud.com)
 * @copyright  2017 Vinil Lakkavatri
 * @company    FiHavock Digital Pvt Ltd
 * @ci_version 3.1.2 echo CI_VERSION;
 * @deprecated File deprecated in Release 2.0.0
 *
 **/
Class Common_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->altcms = $this->load->database('default', TRUE);
    }

    // crud operation queries

    function insert_into_table($table_name,$data){
        $this->altcms->insert($table_name, $data);
        return $this->altcms->insert_id();
    }

    function update_into_table($table_name,$field_name,$update_id,$data){
        $this->altcms->where($field_name, $update_id);
        $this->altcms->update($table_name, $data);
    }

    function update_into_table_with_multiple_condition($table_name,$where_in_condition,$data){
        $this->altcms->where($where_in_condition);
        $this->altcms->update($table_name, $data);
    }

    function delete_into_table($table_name,$field_name,$delete_id){
        $this->altcms->where($field_name, $delete_id);
        $this->altcms->delete($table_name);
    }

    function delete_into_table_with_multiple_condition($table_name,$where_in_condition){
        $this->altcms->where($where_in_condition);
        $this->altcms->delete($table_name);
    }

    function fetch_all_table_data($table_name,$sort_field,$sort_by){
        if (!empty($sort_by) && !empty($sort_field)) {
            $this->altcms->order_by($sort_field, $sort_by);
        }
        $query = $this->altcms->select("*")
                ->get($table_name);
        return $query->result_array();
    }

    function fetch_all_table_data_multiple_condition($table_name,$where_in_condition='',$sort_field='',$sort_by=''){
        if (!empty($sort_by) && !empty($sort_field)) {
            $this->altcms->order_by($sort_field, $sort_by);
        }
        if (!empty($where_in_condition)) {
            $this->altcms->where($where_in_condition);
        }
        $query = $this->altcms->select("*")
                ->get($table_name);
        return $query->result_array();
    }

    function fetch_all_table_data_with_mentioned_fields($table_name,$fields,$sort_field,$sort_by){
        if (!empty($sort_by) && !empty($sort_field)) {
            $this->altcms->order_by($sort_field, $sort_by);
        }
        $query = $this->altcms->select($fields)
                ->get($table_name);
        return $query->result_array();
    }

    function fetch_single_data_from_table($table_name,$field_name,$field_id){
        $this->altcms->where($field_name,$field_id);
        $query = $this->altcms->get($table_name);
        return $query->result_array();
    }

    function fetch_row_count_table($table_name,$field_name,$field_id,$count_id){
        $sql = "select count($count_id) as records from ".$table_name." where ".$field_name."='".$field_id."'";
        $query = $this->altcms->query($sql);
        return $query->result_array();
    }

    function fetch_row_count_table_data_multiple_condition($table_name,$where_in_condition='',$count_id){
        if (!empty($where_in_condition)) {
            $this->altcms->where($where_in_condition);
        }
        $query = $this->altcms->select("count($count_id) as records")
                ->get($table_name);
        return $query->result_array();
    }

    function contact_form_data_datewise($evry_day){
        if (!empty($evry_day)) {
            $company_id = $this->session->userdata('company_id');
            $sql = "SELECT * FROM cms_business_enquiries WHERE date_format(date(Contact_date),'%Y-%m-%d') = '".$evry_day."' AND company_id = '".$company_id."'";
            $query = $this->altcms->query($sql);
            return $query->result_array();
        }
    }

    function contact_form_data_month_year_wise($date){
        if (!empty($date)) {
            $company_id = $this->session->userdata('company_id');
            $sql = "SELECT * FROM cms_business_enquiries WHERE date_format(date(Contact_date),'%Y-%m') = '".$date."' AND company_id = '".$company_id."'";
            $query = $this->altcms->query($sql);
            return $query->result_array();
        }
    }

    function ftp_credentials_exists($company_id=''){
        if (!empty($company_id)) {
            $query = $this->altcms->query('Select * from cms_ftp_credentials where company_id = "'.$company_id.'"');
            return $query->result_array();
        }
    }


}
