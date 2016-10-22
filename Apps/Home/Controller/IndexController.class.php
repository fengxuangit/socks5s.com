<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function _initialize(){
        if (!isset($_SESSION['username'])) {
            
        }
    }

    public function index(){
        $this->display();
    }

    public function buy(){
        $this->display();
    }

    public function download(){

    }

    public function study(){

    }

    public function trial(){
        $this->display();
    }


    public function usage(){
        
    }
}