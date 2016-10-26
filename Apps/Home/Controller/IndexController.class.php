<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function _initialize(){
        $this->headermode = "index";
    }

    public function index(){
        $this->display();
    }

    public function buy(){
        $this->price = M('settings')->field('price')->find()['price'];
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