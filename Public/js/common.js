//js format
String.prototype.format=function(){
  if(arguments.length==0) return this;
  for(var s=this, i=0; i<arguments.length; i++)
    s=s.replace(new RegExp("\\{"+i+"\\}","g"), arguments[i]);
  return s;
};


function palert(message, mode){
    var alerthtml = "<div class=\"alert {0} alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">×</button><strong>{1}!</strong>&nbsp;{2}</div>";
    switch (mode){
        case "success":
            return alerthtml.format("alert-success", "恭喜",message);
            break;

        case "info":
            return alerthtml.format("alert-info", "提示", message);
            break;

        case "warning":
            return alerthtml.format("alert-warning", "警告", message);
            break;

        case "error":
            return alerthtml.format("alert-danger", "失败", message);
            break;
    }

}

 function AjaxReturn(requestUrl, requestData, successCallback, FailedCallback=null) {
     //todo 检查状态，是否适合，如果不适合，则报错
     $.ajax({ 
         type: "POST",
         url:requestUrl,
         cache: false,
         dataType: "json",
         data: requestData
     }).done(
        function (request){
           successCallback(request) 
        }
     ).fail( function(jqXHR, textStatus, errorThrown) {
         FailedCallback(jqXHR, textStatus, errorThrown);
     }).always( function(d) {
    });
}


