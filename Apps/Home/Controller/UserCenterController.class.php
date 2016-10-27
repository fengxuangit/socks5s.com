<?php
namespace Home\Controller;
use Think\Controller;

class UserCenterController extends CommonController{

    public function _initialize(){
        parent::_initialize();
        $this->price = M('settings')->getField('price');
        $this->headermode = "usercenter";
        
    }

    public function index(){
        $this->centermode = "index";
        $this->username = I('session.username');
        $this->balance = M('user')->where("username='%s'", array($this->username))->find()['balance'];
        $this->display();
    }

    public function cart(){
        $username = I('session.username');
        if (I('get.act') == 'del'){
            M('records')->where('id=%d', array(I('get.id')))->delete();   
        }
        #先找之前的记录
        $this->unpay = M('records')->where("user='%s' and ispay=0",array($username))->field('id, buytime, money')->select();
        if (IS_POST){
            $tmparray = $this->unpay;   
            #TODO check buytime Must be a multiple of 30.
            $bcount = GetMoneyCount(I('post.times'), $this->price);
            $data = array(
                'user'  => $username,
                'buytime' => I('post.times'),
                'money'  => $bcount,
                'time'  => time(),
            );
            $insertid = M('records')->add($data);
            #这里是将这次购物的信息添加进去
            $tmp = array('buytime'=>I('post.times'), 'id'=>$insertid, 'money'=>$bcount);
            array_push($tmparray, $tmp);
            $this->unpay = $tmparray;
        }
        $this->display();
    }

    public function orders(){
        $this->centermode = 'orders';
        $username = I('session.username');
        
        //查找用户账户余额
        $this->balance = M('user')->where("username='%s'",array($username))->getField('balance');
        $this->pay = M('records')->where("user='%s'",array($username))->order('time desc')->select();
        //显示订单数量
        $this->ordernumber = M('records')->where("user='%s'",array($username))->count();

        $this->display('index');
    }


    public function recharge(){
        $this->centermode = 'recharge';
        if (IS_POST){
            $card = M('card')->where("cardnum='%s' and cardpass='%s'", array(I('post.cardnum'), I('post.cardpass')))->find();
            if ($card){
                M('user')->where("username='%s'", array(I('session.username')))->save(array('balance'=>$card['money']));
                M('card')->where("cardnum='%s' and cardpass='%s'", array(I('post.cardnum'), I('post.cardpass')))->save(array('status'=>1));
                $data['status'] = 1;
                $data['message'] = "成功充值" . $card['money'] . "元!";
                $data['url'] = U('usercenter/index');
            }else{
                $data['status'] = 0;
                $data['message'] = "充值失败";
            }
            $this->ajaxReturn($data);
        }
        $this->buylink = M('settings')->find()['buylink'];
        $this->display('index');
    }

    public function notifyurl(){

    }

    public function returnurl(){

    }

    public function changepwd(){
        $this->centermode = 'changepwd';
        if (IS_POST){
            // if(!!$result=M('User')->where(array('email'=>I('session.username'), 'password'=>I('post.oldPassword')))->find()){
            // $this->error("对不起，用户名或密码错误");
            $response = array(
                'status'   => 1,
                'message'  => '恭喜更改密码成功 ', 
                'url'      => U('Login/login'),
            );

            $this->ajaxReturn($response);
        }

        $this->display('index');
    }


    public function problem(){

    }

    public function money(){
        
    }

    public function changeemail(){

    }

}