<?php

namespace App\Controllers;

use \CodeIgniter\API\ResponseTrait;
use \OAuth2\Storage\Pdo;
use \CodeIgniter\Controller;
use \CodeIgniter\RESTful\ResourceController;
use App\Models\BugsModel;

class Home extends ResourceController
{
    
    //Default service welcome page    
    public function index(){

        $data = array();
        return view('welcome', $data);        
    }



}
