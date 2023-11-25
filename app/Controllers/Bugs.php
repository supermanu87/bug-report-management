<?php

namespace App\Controllers;

use \CodeIgniter\API\ResponseTrait;
use \OAuth2\Storage\Pdo;
use \CodeIgniter\Controller;
use \CodeIgniter\RESTful\ResourceController;
use App\Models\BugsModel;

class Bugs extends ResourceController
{
    
    // Return all bugs registered in the main view
    public function index(){

        $bugs_model = new BugsModel();
        $all_bugs = $bugs_model->list();
        
        $title = SITE_TITLE . " - " . ENVIRONMENT;
        $data = array();
        $data["title"] = $title;
        $data["bugs"] = $all_bugs["bugs"];
        $data["api_version"] = (ENVIRONMENT === 'development') ? "API VERSION: " . API_VERSION : "";
        
        return view('welcome', $data);  
    }
    
    // Return all bugs registered
    // Optional input parameter: 'query'
    // With 'query' parameter will be returned all bugs by fulltext search query
    public function list(){

        $bugs_model = new BugsModel();

        $query = $this->request->getVar('query') ? $this->request->getVar('query') : null;

        $result = $bugs_model->list($query);
        return $this->respond($result);   
    }


    // Register a new bug
    public function add(){
        
        
        //Set a validation control in order to fetch all the mandatory fields
        // reporter_first_name
        // reporter_last_name
        // bug_description
        $validation =  \Config\Services::validation();
        $validation->setRules([
                'reporter_first_name' => 'required',
                'reporter_last_name' => 'required',
                'bug_description' => 'required'
                    
        ]);


        if($validation->withRequest($this->request)->run()){

            $bugs_model = new BugsModel();
            $data = array();

            $data['reporter_first_name'] = $this->request->getVar('reporter_first_name');
            $data['reporter_last_name'] = $this->request->getVar('reporter_last_name');
            $data['bug_description'] = $this->request->getVar('bug_description');

            $response = $bugs_model->add($data);
            
            if($response){
                    return $this->respond($response);   
            }else{
                    return $this->respond(["status" => false]);
            }
        
            return $this->respond(["status" => false, "message" => $validation->getErrors()], 400);
        }else{
            return $this->respond(["status" => false, "message" => $validation->getErrors()], 400);
        }

    }

}
