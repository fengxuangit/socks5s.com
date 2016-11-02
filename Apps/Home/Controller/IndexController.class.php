<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function _initialize(){
        $this->headermode = "index";
    }

    public function index(){
        $this->indexmode = 'index';
        $this->display();
    }

    public function buy(){
        $this->indexmode = 'buy';
        $this->price = M('settings')->field('price')->find()['price'];
        $this->display('index');
    }


    public function download(){
        $this->indexmode = 'download';

        $this->display('index');
    }

    public function study(){

    }

    public function trial(){
        $this->display();
    }


    public function usage(){
        $this->indexmode = 'usage';

        $this->display('index');
    
    }
}