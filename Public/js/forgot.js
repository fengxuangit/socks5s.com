$(function(){
	$(document).ajaxStart( $.blockUI ).ajaxStop( $.unblockUI );

	$('#sm_pwd').click(function(){
		$('#sm_jg').remove()
		var p = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
		var error = "";
		
		function sm_jg(error){
			$("#sm_pwd").parents('.control-group').before('<div id="sm_jg" class="alert alert-error">'
				+error
				+'<a data-dismiss="alert" class="close">×</a>'
				+'</div>');
		}

		if ($(this).siblings('input').val() == ""){
			sm_jg('E-Mail 不能为空');
		}else if (p.test($(this).siblings('input').val())){
			$.ajax({
				type:'POST',
				url:'/forgot',
				dataType: 'text',
				cache:false,
				data:{
					"email":$(this).siblings('input').val()
				},
				success: function(data){
					$('#smtx').modal({
						backdrop:"static",
						keyboard:true,
						show:true
					});	
				},
				error: function(v){
					sm_jg(v.responseText);
				}
			});	
		}else{
			sm_jg('E-Mail 格式不正确');
		}
	});	
});
