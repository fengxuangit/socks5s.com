<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {

    public function _initialize(){
        if (!isset($_SESSION['username'])) {
            $this->headermode = "guide";
        }else{
            $this->headermode = "user";
        }
    }

    public function index(){
        
    }

    public function login(){
        if (IS_POST){
            if(!!$result=M('User')->where(array('email'=>I('post.email')))->find()){
                if ($result['password'] != I('post.password')){
                    $this->error("对不起，用户名或密码错误");
                }
            }else{
                $this->error("对不起，用户名或密码错误");
            }

            $_SESSION['username'] = I('post.email');
            $this->success("登录成功!");
        }
        $this->display();
    }

    public function register(){

        if (IS_POST){
            //if exists
            if(!!$result=M('User')->where(array('email'=>I('post.email')))->find()){
                $this->error("对不起，此邮箱已经被注册");
            }
            //insert 
            $data = array(
                'email'      => I('post.email'),
                'username'   => I('post.name'),
                'password'   => I('post.password'),
                'invitecode' => I('post.inviteCode'),
                'created_at' => time(),
            );

            $result = M('User')->add($data);
            $this->success("注册成功!");
        }
        $this->display();
    }

    public function verity(){
        $config = array(
            'fontSize' => '14',
            'length' => 3,
            'useNoise' => false,
        );
        $verify = new \Think\Verify($config);
        $verify->entry();
    }

    public function check(){
        if (!IS_POST){
            $this->error('非法访问');
        }
        //验证码判断
        $code = I('post.verity');
        if(!check_verity($code)){
            $this->error("验证码不正确");
        }

        $username = I('post.username');
        $password = I('post.password', '', 'md5');
            
        if(!!$result=M('admin')->where(array('username'=>$username))->find()){
            if ($result['password'] != $password){
                $this->error("对不起，用户名或密码错误");
            }
        }else{
            $this->error("对不起，用户名或密码错误");
        }

        $_SESSION['username'] = $result['username'];
        $_SESSION['privilege'] = $result['privilege'];

        // $this->redirect('Admin/Index/index');

    }

    public function logout(){
        session_unset();
        session_destroy();
        $this->redirect('Login/login');
    }

}




