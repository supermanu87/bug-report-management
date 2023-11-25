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
        $result = $this->builder->get()->getResult();
        return $result;
    }


    public function add($data){

        $result = $this->builder->insert($data);
        if($result){
            $bug_id = $this->db->insertID();
            $bug = $this->get_bug_by_id($bug_id);
            return ["status" => true, "message" => "Bug successfully stored", "inserted_bug" => $bug];
        }

        return $result;
    }
    
    private function get_bug_by_id($bug_id){

        $bug = $this->builder->select()
            ->where("id", $bug_id)
            ->get()
            ->getResult();

        return $bug ? $bug : false;
    }
}