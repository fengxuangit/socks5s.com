<?php
namespace Home\Controller;
use Think\Controller;

class UserCenterController extends CommonController{

    public function _initialize(){
        parent::_initialize();
        $this->price = M('settings')->getField('price');
        $this->headermode = "usercenter";
        
    }
        
    public function test(){
        $str = array(
                7 => 'http://t.cn/RffKOgP',
                70 => 'http://t.cn/RfMxowQ',
            );
        $data = serialize($str);
        print_r($data);

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
        # 先找没有付款的记录
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
            if (!checkToken(I('post.token'))){
                $data['status'] = 0;
                $data['message'] = "请不要重复提交!";
                $data['url'] = U('UserCenter/recharge');
                $this->ajaxReturn($data);
            }
            //返回状态
            $response = array();
            //获取订单信息
            $records = M('records')->where('id=%d',array(I('post.id')))->find();
            //找到这个用户
            $user = M('user')->where("username='%s'", array(I('session.username')))->find();
            if ($user['balance'] < $records['money']){
                $response['status'] = 0;
                $response['message'] =  "账号余额不足";
                $this->ajaxReturn($response);
            }

            $account =  M('ssaccount')->where("username='None'")->order('port desc')->find();
            if ($account === null){
                $response['status'] = 0;
                $response['message'] =  "ss账号库存已无,请联系管理员!";
                $this->ajaxReturn($response);
            }

            //更新使用时间,ss账号
            M('ssaccount')->where("port='%s'", array($account['port']))->setField(array(
                    'buytime'=> time() + C('ONE_DAY_UNIX') * 30, 
                    'streamcount'=> streamCount($records['money']),
                    'username'  => $username,
                )
            );
            M('user')->where("username='%s'",array($username))->setDec('balance', $records['money']);

            // M('ssaccount')->where("port=%d", array($account['port']))->setField('status', 1);
            //更新订单状态
            $flag = M('records')->where('id=%d',array(I('post.id')))->setField('ispay', 1);
        
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
        creatToken();
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
            if (!checkToken(I('post.token'))){
                $data['status'] = 0;
                $data['message'] = "请勿重复提交";
                $data['url'] = U('UserCenter/recharge');
                $this->ajaxReturn($data);
            }
            //查找输入的卡密是否存在
            $card = M('cardpass')->where("cardnum='%s' and cardpass='%s' and status=-1", array(I('post.cardnum'), I('post.cardpass')))->find();
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
                $data['message'] = "充值失败, 未找到此卡密或者已被使用";
            }
            $this->ajaxReturn($data);
        }
        creatToken();
        $this->buylink = unserialize(M('settings')->find()['buylink']);
        $this->display('index');
    }


    public function account(){
        $this->centermode = 'account';
        $this->accounts = M('ssaccount')->where("username='%s'", array(I('session.username')))->select();
        if (IS_POST){
            if (!checkToken(I('post.token'))){
                $data['status'] = 0;
                $data['message'] = "请勿重复提交";
                $data['url'] = U('UserCenter/recharge');
                $this->ajaxReturn($data);
            }  
            $user = M('user')->where("username='%s'", array(I('session.username')))->find();
            if ($user['freeuse']){
                $data['status'] = 0;
                $data['message'] = "对不起,您已经试用过了!";
                $this->ajaxReturn($data);
            }

            $account =  M('ssaccount')->where("username='None'")->order('port desc')->find();
            if ($account === null){
                $response['status'] = 0;
                $response['message'] =  "ss账号库存已无,请联系管理员!";
                $this->ajaxReturn($response);
            }

            //更新使用时间,ss账号
            M('ssaccount')->where("port=%d", array($account['port']))->setField(array(
                    'buytime'=> time() + C('ONE_DAY_UNIX'), //一天
                    'streamcount'=> 1048576, //1G
                    'username' => I('session.username'),
                )
            );
            M('user')->where("username='%s'", array(I('session.username')))->setField('freeuse', 1);

            $data['status'] = 1;
            $data['message'] = "申请试用成功!";
            $data['url'] = U('UserCenter/account', '', '');
            $this->ajaxReturn($data);
        }
        $this->encrypt = M('settings')->find()['encrypt'];

        creatToken();
        //始终显示服务器信息
        $this->servers = M('host')->field('domain,hoststatus')->select();
        $this->display('index');
    }

    //续费加量
    public function rechangess(){
        if (IS_POST){
            if (!checkToken(I('post.token'))){
                $data['status'] = 0;
                $data['message'] = "请勿重复提交";
                $data['url'] = U('UserCenter/account');
                $this->ajaxReturn($data);
            }

            $user = M('user')->where("username='%s'", array(I('session.username')))->find();
            $price = M('settings')->find()['price'];
            if ($user['balance'] < $price){
                $data['status'] = 0;
                $data['message'] = "对不起,余额不足,请充值";
                $data['url'] = U('UserCenter/account');
                $this->ajaxReturn($data);
            }
            $ssaccount = M('ssaccount')->where("port=%d and username='%s'", array(I('post.port'), I('session.username')))->find();

            if ($ssaccount['streamcount'] <= 0 ){
                ssaync($ssaccount['port']);
            }

            $flag = M('ssaccount')->where("port=%d and username='%s'", array(I('post.port'), I('session.username')))->setInc('buytime', time() + C('ONE_DAY_UNIX') * 30);

            $flag = M('ssaccount')->where("port=%d and username='%s'", array(I('post.port'), I('session.username')))->setInc('streamcount', streamCount($price));

            if ($flag){
                $response = array(
                'status'   => 1,
                'message'  => '恭喜充值成功!', 
                'url' => U('UserCenter/account', '', ''),
                );
            }else{
               $response = array(
                'status'   => 0,
                'message'  => '充值失败!', 
                'url' => U('UserCenter/account', '', ''),
                ); 
            }
            $this->ajaxReturn($response);
        }else{
            $this->error("not Get");
        }
    }

    #需要同步到集群数据库中
    public function changesspwd(){
        $this->centermode = 'changesspwd';

        if (IS_POST){
            $code = I('post.verify');
            if(!check_verity($code)){
                $data['status'] = 0;
                $data['message'] = "验证码不正确!";
                $this->ajaxReturn($data);
            }

            $ssaccount =  M('ssaccount')->where("port=%d and username='%s'", array(I('post.ssport'), I('session.username')))->find();
            if ($ssaccount == NULL){
                $data['status'] = 0;
                $data['message'] = "没有找到相应账号！";
                $this->ajaxReturn($data);
            }
            M('ssaccount')->where("port=%d", array($ssaccount['port']))->setField('pass', I('post.newPassword'));
            //同步远程ss服务器
            ssaync($ssaccount['port']);

            $data['status'] = 1;
            $data['message'] = "修改密码成功, 请稍等, 五分钟之内生效!";
            $data['url'] = U('UserCenter/account', '', '');
            $this->ajaxReturn($data);
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
                $this->ajaxReturn($response);
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
    
    public function verity(){
        $config = array(
            'fontSize' => '18',
            'length' => 3,
            'useNoise' => false,
        );
        $verify = new \Think\Verify($config);
        $verify->entry();
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