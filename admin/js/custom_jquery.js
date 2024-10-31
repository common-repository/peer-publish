function sendtoremote(post_id)
{
	//alert("dd");
	console.log('in js function ' + post_id);

	var ajaxurl = jQuery("#customajaxurl").val();
	 var checkValues = jQuery('.check_website:checked').map(function()
            {
                return jQuery(this).val();
            }).get();

 // console.log(checkValues);
jQuery.ajax({
type: "POST",
url: ajaxurl,
//async: false,
data:{action:'PPNM_sendtoremote_distributor_machine',post_id:post_id,websites:checkValues},
success: function(data) {

var sitename = data;
sitename.replace(/\,/g,"");
mystring = sitename.replace(/["]/g , ''); 
console.log(mystring);
if(mystring != ''){
alert('Your post is currently being exported to:'+mystring);
window.location.replace("post.php");
}else{  
window.location.replace("post.php");
}
//console.log(data);
//alert('done');

//console.log('fucntio ok')
}
});


}
