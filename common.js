	//Google Map default settings
	var default_lat = 43.470066;
	var default_lng = -80.547619;
	var default_zoom = 15;

	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}

	function eraseCookie(name) {
		createCookie(name,"",-1);
	}

	function CheckEmpty(id)
	{
		if ((document.getElementById(id).value).trim() == "")
		{
			return true;
		}
		else
		{
			return false;
		}	
	}

	String.prototype.trim = function () 
	{
		return this.replace(/^\s*/, "").replace(/\s*$/, "");
	}

	function IsValidEmail(id)
	{
		pat = /([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})/;
		check = (document.getElementById(id).value).match(pat);
		if (check == null) 
		{
			return false;
		} 
		else 
		{
			return true;
		}
	}
	
	function CheckEmptyGroup( mandatoryFieldIds )
	{
		for (eachField in mandatoryFieldIds)
		{
			if (CheckEmpty(mandatoryFieldIds[eachField]))
			{
				return true;
			}
		}	
		return false;
	}
	
	function HighlightOn(item)
	{
		item.addClass("selectedInput");
	}

	function ButtonHighlightOn(item)
	{
		HighlightOn(item);
		item.addClass("hoveredButton");
	}

	function ButtonHighlightOff(item)
	{
		HighlightOff(item);
		item.removeClass("hoveredButton");
	}

	function HighlightOff(item)
	{
		item.removeClass("selectedInput");
	}

	function BindUI()
	{
		$("input, select, button").bind("focus", function(){
			HighlightOn($(this));
		})

		$("input, select, button").bind("blur", function(){
			HighlightOff($(this));
		})
		
		$("input[type=button], input[type=submit], button").bind("mouseenter",function(){
			ButtonHighlightOn($(this));
		})
		
		$("input[type=button], input[type=submit], button").bind("mouseleave",function(){
			ButtonHighlightOff($(this));
		})

		$("#logoutlink").bind("click", function(e){
			e.preventDefault();
			document.frm_logout.submit();
		})

        $("ul.topnav li a").bind("click", function(e){
                $("a.selectedtab").removeClass("selectedtab");
                $(this).addClass("selectedtab");
        });
		
	}

	$(document).ready(function(){	
		BindUI();
	})

