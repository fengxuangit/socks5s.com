
$(function(){

    $("#frmRegister").validate({
        rules: {
            email: { required: true, email: true},
            password: { required: true, rangelength:[4,20] },
            password2: { required: true, rangelength:[4,20], equalTo:'#password' },
            inviteCode: { required: false, rangelength:[4,11], digits:true }
        },
        messages: {
            email: {required:"不能为空",email:"请输入有效的Email地址"},
            password: {required:"不能为空",rangelength:"必须为4到20个字符"},
            password2: {required:"不能为空",rangelength:"必须为4到20个字符",equalTo:"两次输入的密码不一致"},
            inviteCode: {rangelength:"邀请码位数不对",digits:"邀请码只能包含数字"}
        },
    });

    //验证吗刷新
    $('#verifyCode').click(function (){
        var src = $(this).attr('src');
        if( src.indexOf('?') > 0){  
            $(this).attr("src", src+'&random='+Math.random());
        }else{  
            $(this).attr("src", src.replace(/\?.*$/,'')+'?'+Math.random());  
        }  
    });

    //注册
    $('#signup').click(function (){
        var request = {"email":$("#email").val(),"password":$('#password').val(),"invitecode":$("#inviteCode").val(),"name":$("#email").val(),"verify":$("input[name='verify']").val()};

        AjaxReturn(registerUrl, request,
            function(response){
                if (response['status'] == 1){
                    $("#message").html(palert(response['message'], "success")).show();
                }else if(response['status'] == 0){
                    $("#message").html(palert(response['message'], "error")).show();
                }
                if (response['url'] != null){
                    setTimeout(function () { 
                        window.location.href = response['url'];    
                    }, 1000);
                }
            },
            function (jqXHR, textStatus, errorThrown){
                alert(jqXHR);
                alert(textStatus);
                alert(errorThrown);
            }
        );

    });

    //购物 cart
	 $(".btnOrderMonth").click(function(){
	 	$("input[name$='times']").val(30);
		$('#buyform').submit();
	 });



	 $(".btnOrder").click(function(){
		$("input[name$='times']").val(30 *12);
		$('#buyform').submit();
	 });

    //修改密码
     $('#btnChpw').click(function () {
        if ($('#oldPassword').val() == ""){
            alert("原密码不能为空!");
            return false;
        }

        if($('#newPassword').val().length < 6){
            alert("对不起,密码不能少于6位!");
            return false;
        }

        if ($('#newPassword').val() != $('#newPassword2').val()){
            alert("对不起,两次密码不一致!");
            return false;
        }
        var request = {"oldPassword":$('#oldPassword').val(), "newPassword":$('#newPassword').val()};

        AjaxReturn(changepwdUrl, request,
            function(response){
                if (response['status'] == 1){
                    $("#message").html(palert(response['message'], "success")).show();
                }else if(response['status'] == 0){
                    $("#message").html(palert(response['message'], "error")).show();
                }
                if (response['url'] != null){
                    setTimeout(function () { 
                        window.location.href = response['url'];    
                    }, 1000);
                }
            },
            function (jqXHR, textStatus, errorThrown){
                alert(jqXHR);
                alert(textStatus);
                alert(errorThrown);
            }
        );
     });


     $('#login').click(function (){
        var request = {"email":$('#email').val(), "password":$('#password').val(),"verify":$("input[name='verify']").val()};

        AjaxReturn(logincheck, request,
            function(response){
                if (response['status'] == 1){
                    $("#message").html(palert(response['message'], "success")).show();
                }else if(response['status'] == 0){
                    $("#message").html(palert(response['message'], "error")).show();
                }
                if (response['url'] != null){
                    setTimeout(function () { 
                        window.location.href = response['url'];    
                    }, 1000);
                }
            },
            function (jqXHR, textStatus, errorThrown){
                alert(jqXHR);
                alert(textStatus);
                alert(errorThrown);
            }
        );
     });


    //充值
    $('#btnrecharge').click(function (){
        var requestData = {"cardnum": $('#cardnum').val(), "cardpass":$('#cardpass').val()};
        AjaxReturn(rechargeUrl, requestData, 
            function(response){
                if (response['status'] == 1){
                    $("#message").html(palert(response['message'], "success")).show();
                }else if(response['status'] == 0){
                    $("#message").html(palert(response['message'], "error")).show();
                }
                if (response['url'] != null){
                    setTimeout(function () { 
                        window.location.href = response['url'];    
                    }, 2000);
                }
            },
            function (jqXHR, textStatus, errorThrown){
                alert(jqXHR);
                alert(textStatus);
                alert(errorThrown);
            }
        );

    });


    //余额支付按钮
    $('#payorder').click(function (){

        var id  = $('#payorder').attr('orderId');


        AjaxReturn(orderUrl, {'id':id}, 
            function(response){
                if (response['status'] == 1){
                    $("#message").html(palert(response['message'], "success")).show();
                }else if(response['status'] == 0){
                    $("#message").html(palert(response['message'], "error")).show();
                }
                if (response['url'] != null){
                    setTimeout(function () { 
                        window.location.href = response['url'];    
                    }, 2000);
                }
            },
            function (jqXHR, textStatus, errorThrown){
                alert(jqXHR);
                alert(textStatus);
                alert(errorThrown);
            }
        );


    });


    //取消订单按钮

    $('.btnCancelOrder').click(function (){
        var url = orderUrl + '?act=del&id=' +  $('.btnCancelOrder').attr('orderId');
        $.get(url, function(response){
           if (response['status'] == 1){
                    $("#message").html(palert(response['message'], "success")).show();
                }else if(response['status'] == 0){
                    $("#message").html(palert(response['message'], "error")).show();
                }
                if (response['url'] != null){
                    setTimeout(function () { 
                        window.location.href = response['url'];    
                    }, 500);
            }
        });
    });
     
    //找回密码
    $('#findpwd').click(function (){
        var response = {'email':$('#email').val(), 'step':$('#findpwd').attr('value')};
        AjaxReturn(forgoturl, response, 
            function(response){
                if (response['status'] == 1){
                    $("#message").html(palert(response['message'], "success")).show();
                }else if(response['status'] == 0){
                    $("#message").html(palert(response['message'], "error")).show();
                }
                if (response['url'] != null){
                    setTimeout(function () { 
                        window.location.href = response['url'];    
                    }, 2000);
                }
            },
            function (jqXHR, textStatus, errorThrown){
                alert(jqXHR);
                alert(textStatus);
                alert(errorThrown);
            }
        );
    });


    //邮箱验证吗确认
    $('#getcode').click(function (){
        var response = {'emailverity':$('#verify').val()};
        AjaxReturn(forgot2url, response, 
            function(response){
                if (response['status'] == 1){
                    $("#message").html(palert(response['message'], "success")).show();
                }else if(response['status'] == 0){
                    $("#message").html(palert(response['message'], "error")).show();
                }
                if (response['url'] != null){
                    setTimeout(function () { 
                        window.location.href = response['url'];    
                    }, 2000);
                }
            },
            function (jqXHR, textStatus, errorThrown){
                alert(jqXHR);
                alert(textStatus);
                alert(errorThrown);
            }
        );
    });


    //邮箱验证吗确认
    $('#reset').click(function (){

        if($('#password').val().length < 6){
            alert("对不起,密码不能少于6位!");
            return false;
        }

        if ($('#password').val() != $('#password2').val()){
            alert("对不起,两次密码不一致!");
            return false;
        }
        var request = {"newPassword":$('#password').val()};

        AjaxReturn(reseturl, request, 
            function(response){
                if (response['status'] == 1){
                    $("#message").html(palert(response['message'], "success")).show();
                }else if(response['status'] == 0){
                    $("#message").html(palert(response['message'], "error")).show();
                }
                if (response['url'] != null){
                    setTimeout(function () { 
                        window.location.href = response['url'];    
                    }, 2000);
                }
            },
            function (jqXHR, textStatus, errorThrown){
                alert(jqXHR);
                alert(textStatus);
                alert(errorThrown);
            }
        );
    });


    //修改SS账号密码
    //修改密码
     $('#btnChsspw').click(function () {

        if($('#newPassword').val().length < 6){
            alert("对不起,密码不能少于6位!");
            return false;
        }

        if ($('#newPassword').val() != $('#newPassword2').val()){
            alert("对不起,两次密码不一致!");
            return false;
        }
        var request = {"newPassword":$('#newPassword').val(), 'verify':$("input[name='verify']").val()};

        AjaxReturn(changesspwdUrl, request,
            function(response){
                if (response['status'] == 1){
                    $("#message").html(palert(response['message'], "success")).show();
                }else if(response['status'] == 0){
                    $("#message").html(palert(response['message'], "error")).show();
                }
                if (response['url'] != null){
                    setTimeout(function () { 
                        window.location.href = response['url'];    
                    }, 1000);
                }
            },
            function (jqXHR, textStatus, errorThrown){
                alert(jqXHR);
                alert(textStatus);
                alert(errorThrown);
            }
        );
     });


});


