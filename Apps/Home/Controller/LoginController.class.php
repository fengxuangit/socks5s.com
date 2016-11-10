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


    public function remail(){
        $email  = base64_decode(I('get.info'));
        if ($$email  === ""){
            $this->error("非法访问");
        }
        $veritycode = mail_random();
        $parmeter = authcode($email . "||$veritycode", 'ENCODE', C('AUTHCODE'));
        $verifyUrl = U('Login/emailverity', '', '') . "?token=$parmeter";
        M('user')->where("email='%s'", array($email))->setField('emailverity', $veritycode);
        $flag = SendMail($email, "注册验证", "请点击这里验证登录:". $verifyUrl);
        if ($flag){
            $this->success("发送成功! 请注意查收!");
        }else{
            $this->error("发送失败,请联系管理员!");
        }
    }

    public function login(){
        $this->loginmode = 'login';
        if (IS_POST){
            $code = I('post.verify');
            if(!check_verity($code)){
                $data['status'] = 0;
                $data['message'] = "验证码不正确!";
                $this->ajaxReturn($data);
            }
            if(!!$result=M('User')->where(array('email'=>I('post.email')))->find()){
                // if ($result['emailverity'] != 'ok'){
                //     $parmeter = base64_encode(I('post.email'));
                //     $verifyUrl = U('Login/remail', '', '') . "?info=$parmeter";
                //     $data['status'] = 0;
                //     $data['message'] = "对不起,没有经过验证,请及时查收邮箱验证! 或者没有收到邮件？请点击 <a href=". $verifyUrl ."><strong>这里</strong></a>";
                //     $this->ajaxReturn($data);
                // }
                if ($result['password'] != md5(I('post.password'))){
                    $data['status'] = 0;
                    $data['message'] = "对不起，用户名或密码错误";
                    $this->ajaxReturn($data);
                }
            }else{
                $data['status'] = 0;
                $data['message'] = "对不起，用户名或密码错误";
                $this->ajaxReturn($data);
            }

            $_SESSION['username'] = I('post.email');
            $data['status'] = 1;
            $data['message'] = "登录成功！";
            $data['url'] = U('UserCenter/index', '', '');
            $this->ajaxReturn($data);
        }
        $this->display('login');
    }

    public function register(){
        $this->loginmode = 'register'; 
        if (IS_POST){
            //if exists
            $code = I('post.verify');
            if(!check_verity($code)){
                $data['status'] = 0;
                $data['message'] = "验证码不正确!";
                $this->ajaxReturn($data);
            }
            if(!!$result=M('User')->where(array('email'=>I('post.email')))->find()){
                $data['status'] = 0;
                $data['message'] = "对不起，此邮箱已经被注册!";
                $this->ajaxReturn($data);
            }
            $veritycode = mail_random();
            //insert
            $data = array(
                'email'      => I('post.email'),
                'username'   => I('post.name'),
                'password'   => md5(I('post.password')),
                'invitecode' => I('post.inviteCode'),
                'created_at' => time(),
                'emailverity'=>$veritycode,

            );
            // $parmeter = base64_encode(authcode(I('post.email') . "||$veritycode", 'ENCODE', C('AUTHCODE')));
            // $verifyUrl = U('Login/emailverity', '', '') . "?token=$parmeter";
            // SendMail(I('post.name'), "注册验证", "请点击这里验证登录:". $verifyUrl);
            
            // session('unverifyemail', I('post.email'));
            $result = M('User')->add($data);
            $data['status'] = 1;
            $data['message'] = "注册成功!";
            $data['url'] = U('Login/login', '', '');
            $this->ajaxReturn($data);
        }
        $this->display('login');
    }


    public function emailverity(){
        if (I('get.token') == "" || I('get.token') === null){
            $this->redirect("Login/login");
        }
        $token = authcode(I('get.token'), 'DECODE', C('AUTHCODE'));
        $email = explode('||', $token)[0];
        $code = explode('||', $token)[1];
        $unverifyuser = M('user')->where("email='%s'", array($email))->find();
        if ($unverifyuser){
            if ($unverifyuser['emailverity'] === $code){
                M('user')->where("email='%s'", array($email))->setField('emailverity', 'ok');
                $this->success("验证成功, 请登录! ", U('Login/login'));
            }else{
                $this->error("验证失败, 请登录! ", U('Login/login'));
            }
        }else{
            $this->error("对不起, 邮箱验证吗不正确！ ", U('Login/login'));
        }

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
        if(I('session.emailverify') === "" || I('session.changeemial') === ""){
            $this->error("非法访问", U('Login/forgot'));
        }
        if(IS_POST){
            $code = I('post.emailverity');
            if ($code == I('session.emailverify')){
                session('step', 2);
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
        if(session('changeemial')=== null || session('step') === null || session('emailverify') === null ){
            $this->error("非法访问", U('Login/forgot'));
        }
        if(IS_POST){
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




