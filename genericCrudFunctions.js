function AjaxStart() {
	UpdateStatusMessage('Contacting server...');
}

function AjaxSuccess() {
	UpdateStatusMessage();
}

function AjaxError() {
	UpdateStatusMessage('Failed to communicate with server. Please try again.');
}

/*
**	Checks if an error has occured during the server request
**	based on the return of an empty <div id='cSuccess'></div>
** 	return: bool
*/
function HandlerErrorOccured() {
	if ($('div#cSuccess').length != 0)
	{
		if (!$('div#cSuccess').html())
		{
			return true;
		}
	}
	return false;
}

/*
**	Does all the visual cleanup work when the first "Add" button is clicked
** 	return: none
*/
function InitializeAdd() {
	$('div#responseContainer').children().remove();
	$('div.message').fadeOut();

	//IE6 messes up the position of the image
	//while sliding, so we hide the image and slide
	if (jQuery.browser.msie) 
	{
		$('.crudimage').hide();
	}
	
 //   $('div#slidingInformation').slideDown('slow', function(){
 //   	if (jQuery.browser.msie)
 //   	{
 //   		$('.crudimage').show(); //IE6 - unhide the image once slide completes
 //   	}
 //   });
	$('#edit, #delete').hide();
	$('#add').show();
	ClearFormFields();	
	$('#masterDropDown').attr('value','');
}

/*
**	When the master drop down is changed,
**	this method takes it's value queries the 
**	backend, gets a response, places it into
**	a response container, and from there,
**	maps the responses into the form
** 	return: none
*/
function MasterDropDownChange(dropDownValue, requestHandler, callBack, callBack2) {
	$('div#responseContainer').children().remove();
	if (dropDownValue)
	{
		$('div#message').fadeOut('slow');
		$('input#add').hide();
		$('input#edit, input#delete').show();
			
		$.post(requestHandler + '?get=1', {id: dropDownValue}, 
			function(response) {
			//	if (jQuery.browser.msie)
			//	{
			//		$('.crudimage').hide(); //IE6 hack
			//	}
				$('div#responseContainer').html(response);
					RepopulateFormFields();
					UpdateStatusMessage('');
					if (typeof callBack != 'undefined') callBack();
					if (typeof callBack2 != 'undefined') callBack2();

			//	$('div#slidingInformation').slideUp('slow',
			//	function(){
			//		$('div#slidingInformation').slideDown('slow', function(){
			//			if (jQuery.browser.msie)
			//			{
			//				$('.crudimage').show(); //IE6 hack
			//			}
			//		
			//		});
			//		
			//	});
			}
		);
	}
	else
	{
		if (jQuery.browser.msie)
		{
			$('.crudimage').hide(); //IE6 hack
		}
		
		//$('div#slidingInformation').slideUp('slow');
		InitializeAdd();
		UpdateStatusMessage('');
		return false;
	}
}

/*
**	When the edit button is clicked,
**	this method sends the edit request to
**	the handler, and then sends the get 
**	request to repopulate the form with
**	the new edited response
** 	return: none
*/
function GenericEdit (mandatoryFieldIds, requestHandler, callBack, extrarequest) {
	$('div#responseContainer').children().remove();
	if (!CheckEmptyGroup(mandatoryFieldIds))
	{
		if (typeof extrarequest != 'undefined')
		{
			$.post(requestHandler + '?edit=1&get=1' + extrarequest, GenerateFormTableMapping(),
				function(response){
					$('div#responseContainer').html(response);
					RepopulateFormFields();
					if (typeof callBack != 'undefined' && callBack != null) callBack();
					RepopulateMasterDropDown(requestHandler, null, extrarequest);
				})
		}
		else
		{
			$.post(requestHandler + '?edit=1&get=1', GenerateFormTableMapping(),
				function(response){
					$('div#responseContainer').html(response);
					RepopulateFormFields();
					if (typeof callBack != 'undefined' && callBack != null) callBack();
					RepopulateMasterDropDown(requestHandler);
				})

		}
	}
	else
	{
		alert('One or more mandatory fields have been left blank!');
	}
}

/*
**	When the add button is clicked,
**	this method sends the add request to
**	the handler
** 	return: none
*/
function GenericAdd(mandatoryFieldIds, requestHandler, callBack, extrarequest) {
	$('div#responseContainer').children().remove();
	if (!CheckEmptyGroup(mandatoryFieldIds))
	{
		if (typeof extrarequest != 'undefined') {
			$.post(requestHandler + '?add=1' + extrarequest, GenerateFormTableMapping(),
				function(response){
					$('div#responseContainer').html(response);
					if (!HandlerErrorOccured())
					{
						//$('div#slidingInformation').slideUp('slow');
						RepopulateFormFields();
						if (typeof callBack != 'undefined' && callBack != null) callBack();
						RepopulateMasterDropDown(requestHandler, null, extrarequest);
					}
					else
					{
						UpdateStatusMessage();
					}
				})
		}
		else
		{
			$.post(requestHandler + '?add=1', GenerateFormTableMapping(),
				function(response){
					$('div#responseContainer').html(response);
					if (!HandlerErrorOccured())
					{
						//$('div#slidingInformation').slideUp('slow');
						RepopulateFormFields();
						if (typeof callBack != 'undefined') callBack();
						RepopulateMasterDropDown(requestHandler);
					}
					else
					{
						UpdateStatusMessage();
					}
				})
		}

	}
	else
	{
		alert('One or more mandatory fields have been left blank!');
	}
}

/*
**	When the delete button is clicked,
**	this method sends the delete request to
**	the handler
** 	return: none
*/
function GenericDelete(requestHandler, extrarequest) {
	$('div#responseContainer').children().remove();
	if (typeof extrarequest != 'undefined') {
		$.post(requestHandler + '?delete=1' + extrarequest,{id: $('#masterDropDown').attr('value')},function(response){
			$('div#responseContainer').html(response);
			
			if (!HandlerErrorOccured())
			{
				//$('div#slidingInformation').slideUp('slow');
				ClearFormFields();
				RepopulateMasterDropDown(requestHandler, null, extrarequest);
			}
			else
			{
				UpdateStatusMessage();
			}
			$.unblockUI();	
		})
	}
	else
	{
		$.post(requestHandler + '?delete=1',{id: $('#masterDropDown').attr('value')},function(response){
			$('div#responseContainer').html(response);
			
			if (!HandlerErrorOccured())
			{
				//$('div#slidingInformation').slideUp('slow');
				ClearFormFields();
				RepopulateMasterDropDown(requestHandler);
			}
			else
			{
				UpdateStatusMessage();
			}
			$.unblockUI();	
		})
	}
}

/*
**	Given a message string, this method
**	updates the message on div id="message"
**	If no message string is given, then
**	it looks for a message in div id="cMessage"
**	and assigns that as the message.
**	It also takes care of colouring the message
**	if an error occurs.
** 	return: none
*/
function UpdateStatusMessage(message)
{
	if (typeof message == 'undefined') {
		message = $('div#cMessage').html();
		if (message)
		{
			UpdateStatusMessage(message);
		}
		else
		{
			UpdateStatusMessage('');
		}	
	}
	else {
		$('div#message').removeClass('errorMessage');
		if ( message ) {
			$('div#message').html(message).fadeIn('slow');
		}
		else {
			$('div#message').fadeOut('slow');
		}

		if (HandlerErrorOccured()) {
			$('div#message').addClass('errorMessage');
		}
	}
}

/*
**	Resets all text boxes and select boxes
**	in the form.
** 	return: none
*/
function ClearFormFields()
{
	$(document).ready(function(){

		$('div#slidingInformation input[type=text],	div#slidingInformation select, div#slidingInformation textarea').each(function(){
			$(this).attr('value','');	//Reset all text fields and select boxes
		})
	});
}

/*
**	Based on the contents of the response container
**	this method repopulates the form fields
** 	return: none
*/
function RepopulateFormFields()
{
	$(document).ready(function(){

		var formInputSelector =	$('div#slidingInformation input[type=text], \
						div#slidingInformation select, div#slidingInformation textarea');
		var responseContainerSelector = $('div#responseContainer'); 
		formInputSelector.each(function(){
			var currentlySelectedInput = $(this);
			var thisid = $(this).attr('id');
			responseContainerSelector.each(function(){
				var currentResponseObject = $(this);
				if ($(this).children('.' + thisid ).html())
				{
					currentlySelectedInput.attr('value', $('div.' + thisid).html());
					currentResponseObject.children('.' + thisid).remove();
					return;
				}
				currentlySelectedInput.attr('value', '');
			});
		});
	});
}


/*
**	Uses the handler to send a request whose
** 	response populates the master drop down box
**	Also, if it had a previously selected value
**	that value gets reselected after population
** 	return: none
*/
function RepopulateMasterDropDown(requestHandler, select, extrarequest) {
	if (typeof extrarequest != 'undefined') {
		$('#masterDropDown').load(requestHandler + '?getlist=1' + extrarequest, function(){
			var idSelector = $('div#responseContainer').children('div.xid:first');
			if (select)
			{
				$('#masterDropDown').attr('value', select);
			}
			else if (idSelector.html())
			{
				$('#masterDropDown').children().each(function(){
					if ($(this).attr('value') == idSelector.html())
					{
						$(this).attr('selected', 'selected');
						return;
					}
				})
			}
		});
	}
	else {
			
		$('#masterDropDown').load(requestHandler + '?getlist=1', function(){
			var idSelector = $('div#responseContainer').children('div.xid:first');
			if (select)
			{
				$('#masterDropDown').attr('value', select);
			}
			else if (idSelector.html())
			{
				$('#masterDropDown').children().each(function(){
					if ($(this).attr('value') == idSelector.html())
					{
						$(this).attr('selected', 'selected');
						return;
					}
				})
			}
		});
	}
}


