
$(function(){

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
        // AjaxReturn(changepwdUrl, request, 'post', successCallback);
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


});


