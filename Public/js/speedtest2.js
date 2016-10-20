
function showResult(route,ip,data){
	$("#rtable tr:last").after("<tr><td>"+route+"</td><td>"+ip+"</td><td>"+data+"</td></tr>");
}
$("#result").empty();
for(var i=0;i<ips.length;i++){
	if (i==0) continue;
	var p = new Ping();
	p.ping(routes[i],ips[i],showResult,0); 
}

