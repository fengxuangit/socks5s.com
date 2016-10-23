<?php
namespace Home\Controller;
use Think\Controller;

class UserCenterController extends CommonController{

    public function index(){
        $this->display();
    }

   public function cart(){
        if (IS_POST){
            if (!isset($_SESSION['username'])){
                $data = array(
                    'status'  => 0,
                    'message' => '没有登录，请登录之后再试!',
                    'url'     => U('Login/login'),
                );
                $this->ajaxReturn($data);
            }
            $username = I('session.username');
            #先找之前的记录
            $this->unpay = M('records')->where("user='%s' and ispay=0",array('hack@qq.com'))->field('buytime')->select();
            #TODO check buytime Must be a multiple of 30.
            $data = array(
                'user'  => $username,
                'buytime' => I('post.times'),
            );
            $pay = M('records')->add($data);
            array_push($this->unpay, array('buytime'=>I('post.times')));
            print_r($this->unpay);
        }
        $this->display();
    }

}