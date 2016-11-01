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
        $this->loginmode = 'login';
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
        $this->display('login');
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

    public function forgot(){
        $this->loginmode = "forgot";
        if (IS_POST){
            $email = I('post.email');
            $user = M('user')->where("email='%s'",array($email))->find();
            if ($user){
                $code = mail_random();
                $flag = SendMail($user['email'], "密码重置", "你的验证码为<br/><strong>".$code."</strong>");
                $flag = 1;
                if ($flag){
                    session('emailverify', $code);
                    session('changeemial', I('post.email'));
                    $data['status'] = 1;
                    $data['message'] = "已经发送验证码到你的邮箱,请在20分钟内及时修改,否则验证码过期";
                    $data['url'] = U('Login/forgot2');
                    $this->ajaxReturn($data);
                }else{
                    $data['status'] = 0;
                    $data['message'] = "邮件发送错误,请检查邮箱是否正确,或联系管理员!";
                    $this->ajaxReturn($data);
                }
            }else{
                $data['status'] = 0;
                $data['message'] = "不存在此邮箱";
                $this->ajaxReturn($data);
            }
        }
        

        $this->display('login');
    }


    public function forgot2(){
        $this->loginmode = "forgot_2";
        if(IS_POST){
            if(I('session.emailverity')=== null || I('session.changeemial')=== null){
                $data['status'] = 0;
                $data['message'] = "非法访问";
                $data['url'] = U('Login/forgot');
                $this->ajaxReturn($data);
            }
            $code = I('post.emailverity');
            if ($code == I('session.emailverify')){
                $data['status'] = 1;
                $data['message'] = "验证正确！";
                $data['url'] = U('Login/reset');
                $this->ajaxReturn($data);
            }
        }

        $this->display('login');
    }


    public function reset(){
        $this->loginmode = "reset";
        if(IS_POST){
            if(session('changeemial')=== null || I('session.changeemial')=== null){
                $data['status'] = 0;
                $data['message'] = "非法访问";
                $data['url'] = U('Login/forgot');
                $this->ajaxReturn($data);
            }
            $password = md5(I('post.newPassword'));
            $flag = M('user')->where("email='%s'",array(I('session.changeemial')))->setField('password', $password);
            if ($flag){
                $data['status'] = 1;
                $data['message'] = "修改密码完成,请重新登录";
                $data['url'] = U('Login/login');
                $this->ajaxReturn($data);  
            }else{
                $data['status'] = 0;
                $data['message'] = "修改密码失败,请重试!" . I('session.changeemial');
                session_unset();
                session_destroy();
                $data['url'] = U('Login/forgot');
                $this->ajaxReturn($data); 
            }
                 
        }
        
        $this->display('login');
    }

}




