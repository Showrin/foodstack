// ========== Script For Adding Sliding Animation to Notification Box =========== 

	$('#friend-request-btn').click(function() {

		$('.friend-request-box-holder').delay(250).slideToggle(250);

	})



// ======Script for Hiding Notification Box by Clicking outside it ============

// Source: http://activelab.io/code-snippets/use-jquery-to-hide-a-div-when-the-user-clicks-outside-of-it 
	
	$(document).ready(function()
	{
	    $("body").mouseup(function(e)
	    {
	        var subject = $("#friend-request-explorer"); 
	        var btn = $("#friend-request-btn");

	        if(e.target.id != subject.attr('id') && !subject.has(e.target).length && e.target.id != btn.attr('id') && !btn.has(e.target).length)
	        {
	            subject.slideUp(250);
	        }
	    });
	});
