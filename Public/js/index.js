
$(function(){
	$(document).ajaxStart( $.blockUI ).ajaxStop( $.unblockUI );


	function order(serviceId,term) {
		//todo 检查状态，是否适合，如果不适合，则报错
		$.ajax({ 
			type: "post",
			url:"/order",
			cache: false,
			dataType: "json",
			data: {"serviceId":serviceId, "term":term}
			})
		.done( function(d) { 
			if(d.result==0){
				//alert(d.msg);
				window.location.replace("http://www.ssjiasu.xyz/login?redirect=/my/cart");
			}else if (d.result==1){
				window.location.replace("../../login-redirect=-.htm"/*tpa=https://www.ssjiasu.xyz/login?redirect=/*/);
			}else{
				alert(d.msg);
			}

		}).fail( function(jqXHR, textStatus, errorThrown) {
			alert(errorThrown);
		}).always( function(d) {
		});
	}

	 $(".btnOrderMonth").click(function(){
		order( $(this).attr("data") , "month");
	 });



	 $(".btnOrder").click(function(){
		order( $(this).attr("data") , "year");
	 });

});


