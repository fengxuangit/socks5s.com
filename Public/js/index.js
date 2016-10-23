
$(function(){
	 $(".btnOrderMonth").click(function(){
	 	$("input[name$='times']").val(1);
		$('#buyform').submit();
	 });



	 $(".btnOrder").click(function(){
		$("input[name$='times']").val(12);
		$('#buyform').submit();
	 });
	// $(document).ajaxStart( $.blockUI ).ajaxStop( $.unblockUI );


	// function order(serviceId,term) {
	// 	//todo 检查状态，是否适合，如果不适合，则报错
	// 	$.ajax({ 
	// 		type: "post",
	// 		url:orderUrl,
	// 		cache: false,
	// 		dataType: "json",
	// 		data: {"hostid":serviceId, "times":term}
	// 	}).done( function(response) { 
	// 		if (response['status'] == 1){
	// 			window.location.href = orderUrl; 
	// 		}else if(response['status'] == 0){
	// 			$("#message").html(palert(response['message'], "error")).show();
	// 			setTimeout(function () { 
	// 				window.location.href = loginUrl;    
 //    			}, 1000);
	// 		}
	// 	}).fail( function(jqXHR, textStatus, errorThrown) {
	// 		alert(errorThrown);
	// 	}).always( function(d) {
	// 	});
	// }


});


