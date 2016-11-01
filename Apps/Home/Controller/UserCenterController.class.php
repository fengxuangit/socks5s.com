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
        #先找没有付款的记录
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
        if (IS_POST){
            //返回状态
            $response = array();
            //更新订单状态
            $flag = M('records')->where('id=%d',array(I('post.id')))->setField('ispay', 1);
            //获取订单信息
            $records = M('records')->where('id=%d',array(I('post.id')))->find();
            //找到这个用户
            $user = M('user')->where("username='%s'", array(I('session.username')))->find();
            if ($user['balance'] < $records['money']){
                $response['status'] = 0;
                $response['message'] =  "账号余额不足";
                $this->ajaxReturn($response);
            }
            //判断这个用户没有购买记录,新添记录
            if ($user['port'] == 0){
                //取一个没有使用过的ss账号
                $account =  M('ssaccount')->where("status=0")->order('port desc')->find();
                if ($account === null){
                    $response['status'] = 0;
                    $response['message'] =  "ss账号库存已无,请联系管理员!";
                    $this->ajaxReturn($response);
                }
                //更新使用时间,ss账号
                M('user')->where("username='%s'", array(I('session.username')))->setField(array('port'=>$account['port'], 'sspass'=>$account['pass'], 'buytime'=>$records['buytime'], 'balance'=>$user['balance']-$records['money']));
                M('ssaccount')->where("port=%d", array($account['port']))->setField('status', 1);
            }else{
            //已经有了购买记录，只添加时间。
                $flag = M('user')->where("username='%s'", array(I('session.username')))->setField(array('buytime'=> $records['buytime'], 'balance'=>$user['balance']-$records['money']));
                if ($flag){
                    $response['status'] = 1;
                    $response['message'] =  "支付成功";
                    $response['url'] = U('UserCenter/account', '', '');
                }else{
                    $response['status'] = 0;
                    $response['message'] =  "支付失败, 请联系管理员!";
                }
                $this->ajaxReturn($response);
            }
            $response['status'] = 1;
            $response['message'] =  "支付成功";
            $response['url'] = U('UserCenter/account', '', '');
            $this->ajaxReturn($response);
        }

        //删除
        if (I('get.act') === 'del' && I('get.id') != ''){
            $flag = M('records')->delete(I('get.id'));
            if ($flag){
                $response['status'] = 1;
                $response['message'] =  "删除成功";
            }else{
                $response['status'] = 0;
                $response['message'] =  "删除失败, 请联系管理员!";
            }
            $response['url'] =  U('UserCenter/orders', '', '');;
            $this->ajaxReturn($response);
        }
        
        //查找用户账户余额
        $this->balance = M('user')->where("username='%s'",array($username))->getField('balance');
        $this->pay = M('records')->where("user='%s' and ispay=0",array($username))->order('time desc')->select();
        //显示订单数量
        $this->ordernumber = count($this->pay);

        $this->display('index');
    }


    public function recharge(){
        $this->centermode = 'recharge';
        if (IS_POST){
            //查找输入的卡密是否存在
            $card = M('cardpass')->where("cardnum='%s' and cardpass='%s'", array(I('post.cardnum'), I('post.cardpass')))->find();
            if ($card){
                //更新用户的balance 为本次充值的金额
                M('user')->where("username='%s'", array(I('session.username')))->setInc('balance',$card['money']);
                //将这个卡标记为已使用
                M('cardpass')->where("cardnum='%s' and cardpass='%s'", array(I('post.cardnum'), I('post.cardpass')))->save(array('status'=>1));
                //添加一条充值记录
                M('recharge')->add(array(
                    'user'      => I('session.username'),
                    'money'     => $card['money'],
                    'create_at' => time(),
                ));
                $data['status'] = 1;
                $data['message'] = "成功充值" . $card['money'] . "元!";
                $data['url'] = U('UserCenter/index');
            }else{
                $data['status'] = 0;
                $data['message'] = "充值失败";
            }
            $this->ajaxReturn($data);
        }
        $this->buylink = M('settings')->find()['buylink'];
        $this->display('index');
    }


    public function account(){
        $this->centermode = 'account';
        $user = M('user')->where("username='%s'", array(I('session.username')))->find();
        if ($user['sspass'] != ""){
            $this->accounts = array(
                0 => array(
                    'expire'    => time() + ($user['buytime'] * C('ONE_DAY_UNIX')),
                    'port'      => $user['port'],
                    'sspass'    => $user['sspass'],
                ),
            );
        }
        
        $this->display('index');
    }

    public function changepwd(){
        $this->centermode = 'changepwd';
        if (IS_POST){
            $result = M('User')->where(array('username'=>I('session.username'), 'password'=>md5(I('post.oldPassword'))))->find();
            if ($result === NULL){
                $response = array(
                    'status'   => 0,
                    'message'  => '原密码不正确! 请重新输入',
                );
            }else{
                $flag = M('user')->where("username='%s'", array(I('session.username')))->setField('password', md5(I('post.newPassword')));
                if ($flag){
                    $response = array(
                    'status'   => 1,
                    'message'  => '恭喜更改密码成功 ', 
                    'url'      => U('Login/login', '', ''),
                    );
                }else{
                   $response = array(
                    'status'   => 0,
                    'message'  => '密码更新错误,请联系管理员 ', 
                    ); 
                }
                
            }
            session_unset("username");
            $this->ajaxReturn($response);
        }

        $this->display('index');
    }


    public function problem(){
        $this->centermode = 'problem';
        $this->display('index');   
    }

    public function money(){
        $this->centermode = 'money';
        $this->moneys = M('recharge')->where("user='%s'", array(I('session.username')))->select();
        $this->display('index');
    }
}