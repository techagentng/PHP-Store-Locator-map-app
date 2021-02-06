/*
Login
*/
jQuery(document).on('click', '#login_btn', function(event) {
	event.preventDefault();
	$('#login_form #notification').html('');
	var serialized_data = jQuery("#login_form").serialize();
	$.ajax({
	  type: 'POST',
	  data: serialized_data,
	  dataType: 'json',
	  url: 'listeners/check_login.php',
	  success: function(msg) {
	  	if(msg.code==1) {
	  		$('#login_form #notification').html(msg.display);
	  	}
	  	else if(msg.code==2) {
	  		window.location.reload();
	  	}
	  }
	});
});
