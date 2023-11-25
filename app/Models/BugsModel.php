<?php
namespace App\Models;

use CodeIgniter\Model;

class BugsModel extends Model{

    protected $db;
    protected $table;
    
    public function __construct(){
       $this->db = \Config\Database::connect();
       $this->table = 'bugs'; 
       $this->builder = $this->db->table($this->table);
        
    }

    public function list($query = null){

       $this->builder->select();
        if($query){
            $where = "bug_description LIKE '%".$query."%' OR reporter_first_name LIKE '%".$query."%' OR reporter_last_name LIKE '%".$query."%'";
            $this->builder->where($where);
        }
        $bugs = $this->builder->get()->getResult();
        $result = array();
        if(ENVIRONMENT === 'development'){
            $result["api_version"] = API_VERSION;
        }
        $result["bugs"] = $bugs;
        
        return $result;
    }


    public function add($data){

        $response = array();
        
        try{

            $result = $this->builder->insert($data);
            if($result){
                
                $bug_id = $this->db->insertID();
                $bug = $this->get_bug_by_id($bug_id);
                
                $response["status"] = true;
                $response["message"] = "Bug successfully stored";
                $response["inserted_bug"] = $bug;
                
                if(ENVIRONMENT === 'development'){
                    $response["api_version"] = API_VERSION;
                }

                return $response;
            }

            
        }catch(Exception $e){
            $response["status"] = false;
            $response["message"] = "Error inserting bug";
            $response["error"] = $e->getMessage();
            
            if(ENVIRONMENT === 'development'){
                $response["api_version"] = API_VERSION;
            }

            return $response;
        }

    }
    
    private function get_bug_by_id($bug_id){

        $bug = $this->builder->select()
            ->where("id", $bug_id)
            ->get()
            ->getResult();

        return $bug ? $bug : false;
    }
}