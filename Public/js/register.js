
//登陆注册重置密码
$(function(){
	$(document).ajaxStart( $.blockUI ).ajaxStop( $.unblockUI );


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
		invalidHandler : function(){ return false; },
		submitHandler : function(){
			$(".alert-block").remove()
			$.ajax({
					type: "POST",
					url: '/register',
					dataType: 'text',
					cache:false,
					data: {
						"email":$("#email").val(),
						"password":$.md5($('#password').val()),	
						"inviteCode":$("#inviteCode").val(),
						"name":$("#email").val()
						  }
				}).done( function(data){
						 /* alert("注册成功，点击确定转到登录界面开始登录。"); */
						 alert("注册成功，我们给您发了一封Email，请点击Email里面的链接验证您的账号。");
						   
						window.location.href = "../../login.htm"/*tpa=https://www.ssjiasu.xyz/login*/;
				}).fail( function(jqXHR, textStatus, errorThrown) {
					var v=jqXHR;
						var errmsg=v.responseText;
							if (v.status == '991'){
								errmsg='E-Mail 或 密码 不能为空';
							}else if(v.status == '998'){
								errmsg='E-Mail地址已经存在,如果您不知道密码，可以<a href="../../forgot.htm"/*tpa=https://www.ssjiasu.xyz/forgot*/>找回密码</a>';
							}
							var e='<div class="alert alert-block">'
								+'<button type="button" class="close" data-dismiss="alert">×</button>'
								+' <h4>错误！</h4>'
								+errmsg
								+' </div>'
							$("#frmRegister > fieldset > legend").after(e);

				}).always( function(d) {

				});

		}});

});

