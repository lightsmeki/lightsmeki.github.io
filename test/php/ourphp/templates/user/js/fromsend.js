	$(function(){
		$(".registerform").Validform();  //就这一行代码！;
	})
	
	var wait=120; 
	function sendsms() { 
	var mobiles = $("#mobiles").attr("value");
	if(mobiles == ""){
		alert("请填写手机号");
		return;
	};
		$.ajax({
		url: '../../function/api/sms/sms.php',
		type: 'POST', 
		async: false,
		data:{mobilesn:mobiles},
		dataType: 'jsonp',
		jsonp: 'callback',
		success: function(result) {
				document.getElementById('mobilesn').innerHTML=result.mobilesn;
			}
		});
	}
	
	function time(o) { 
		var mobiles = $("#mobiles").attr("value");
		if(mobiles == ""){
			return;
		};
		if (wait == 0) { 
			o.removeAttribute("disabled"); 
			o.value="免费获取验证码"; 
			wait = 120; 
		} else { 
			o.setAttribute("disabled", true); 
			o.value="重新发送(" + wait + ")"; 
			wait--; 
			setTimeout(function() { 
				time(o) 
			}, 1000) 
		};
	} 
	document.getElementById("btn").onclick=function(){time(this);sendsms();}