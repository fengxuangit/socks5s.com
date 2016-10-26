
//登陆注册重置密码
$(function(){
	$(document).ajaxStart( $.blockUI ).ajaxStop( $.unblockUI );


	$("#frmLogin").validate({
		rules: {
			email: { required: true, email: true},
	        password: { required: true, rangelength:[4,20] }
	    },
	    messages: {
			email: {required:"不能为空",email:"请输入有效的Email地址"},
			password: {required:"不能为空",rangelength:"必须为4到20个字符"}
		},
		invalidHandler : function(){ return false; },
		submitHandler : function(){
			$(".alert-block").remove()
			$.ajax({
					type: "POST",
					url: logincheck,
					dataType: 'text',
					cache:false,
					data: {
						"email":$("#email").val(),
						"password":$.md5($('#password').val())
					}
				}).done( function(data){
					data = $.parseJSON(data);
					if (data['status'] == 0){
						$("#message").html(palert(data['info'], "warning")).show();
					}else if (data['status'] == 1){
						 $("#message").html(palert(data['info'], "success")).show();
						setTimeout(function () { 
					    	window.location.href = loginsuccredirectUrl;    
    					}, 1000);
					}
				}).fail( function(jqXHR, textStatus, errorThrown) {
					var v=jqXHR;
					var errmsg=v.responseText;
						if (v.status == '998'){
							errmsg='登录失败：账号不存在，如果以前您注册过，<a href="https://blog.ssjiasu.xyz/archives/269">请看这里</a>。或者点击 <a href="/register?email='+$("#email").val()+'">立即注册</a>';
						}else if(v.status == '994'){
							errmsg='登录失败：密码不正确。<a href="/forgot?email='+$("#email").val()+'">忘记密码</a>';
						}else if(v.status == '999'){
							errmsg='登录失败：账号没有验证，刚才给您重新发了验证邮件，请按邮件内容验证。';
						}

						var e='<div class="alert alert-block">'
								+'<button type="button" class="close" data-dismiss="alert">×</button>'
								+' <h4>错误!</h4>'
								+errmsg
								+' </div>'
						$("#frmLogin > fieldset > legend").after(e);

				}).always( function(d) {

				});

		}});

});

