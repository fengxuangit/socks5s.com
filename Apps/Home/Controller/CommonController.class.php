<?php

namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller{

    public function _initialize() {
        if (!isset($_SESSION['username'])) {
            $this->headermode = "guide";
            $this->redirect('Login/login');
        }else{
            $this->headermode = "usercenter";
        }
    }

}