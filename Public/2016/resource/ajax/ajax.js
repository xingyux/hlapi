var currentAjax = null;
function getPost(u,s,t,f,d,e)
{
var c=true;
if(t==null||t==undefined||t==""){c=false;}
if(!d){
	var AjaxStr="";
	currentAjax=$.ajax({
	type: "post",
	url: u,
	data:s,
	async:c,
	complete: function(XMLHttpRequest, textStatus){
	AjaxStr=XMLHttpRequest.responseText;
	//if(textStatus=="error"){AjaxStr="error";}
	if(c){eval(t+"(AjaxStr,f)");}
	},
	error: function(){
	AjaxStr= "Error:";
	}}
	);
	if(!c){return AjaxStr;}
	}
else{
	var AjaxStr="";
	currentAjax=$.ajax({
	dataType: d,
	type: "post",
	url: u,
	data:s,
	async:c,
	success: function (data) {
		t(data,f);
	},

	error: function (request, status, errorThrown) {
					if(e){
						e(request,f);
					}
				}
	}
	);
	if(!c){return AjaxStr;}
	}	
}

function stopAjax(){  
   
    if(currentAjax) {currentAjax.abort();}  
}  