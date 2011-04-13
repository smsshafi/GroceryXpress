<?php include 'siteconfig.php'; ?>
<?php $page_title = 'Sign Up'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	<?php echo $sCssFile.$sJQueryFile.$sCommonJsFile.$sNotificationJsFile; ?>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAACbE9got-Ty4wRjiRSSNBDRTSips-EQlAUONoGqj0ZBB2PknwtRSwYV_QfPVLJ2QyMimN_nEp3O8vFg" type="text/javascript"></script>
	<script type="text/javascript">

        var mapTimeoutReference;
        // showLocation() is called when you click on the Search button
		// in the form.  It geocodes the address entered into the form
		// and adds a marker to the map at that location.
		function showLocation() {
            
            var address = $('#address').attr('value');
            if (address != null) {
                geocoder.getLocations(address, addAddressToMap);
            }
		}

        // addAddressToMap() is called when the geocoder returns an
		// answer.  It adds a marker to the map with an open info window
		// showing the nicely formatted version of the address and the country code.
		function addAddressToMap(response) {
			map.clearOverlays();
			if (!response || response.Status.code != 200) {
				showNotification("Sorry, we were unable to recognize your address. Please try a different address.");
				} else {
                $('#lng').attr('value', '');
                $('#lat').attr('value', '');
                $('#city').attr('value', '');
                $('#province').attr('value', '');
                $('#postalcode').attr('value', '');
				place = response.Placemark[0];
				point = new GLatLng(place.Point.coordinates[1],
									place.Point.coordinates[0]);
				marker = new GMarker(point);
				map.addOverlay(marker);
				marker.openInfoWindowHtml(place.address);
				$('#lng').attr('value', place.Point.coordinates[0]);
				$('#lat').attr('value', place.Point.coordinates[1]);
                if (place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName)
				{
					$('#province').attr('value', place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName);
				}
				else
				{
					$('#province').attr('value', '');
				}
                if (place.AddressDetails.Country.AdministrativeArea.Locality)
                {
    				if (place.AddressDetails.Country.AdministrativeArea.Locality.LocalityName)
    				{
    					$('#city').attr('value', place.AddressDetails.Country.AdministrativeArea.Locality.LocalityName);
    				}

                    if (place.AddressDetails.Country.AdministrativeArea.Locality.PostalCode.PostalCodeNumber)
    				{
    					$('#postalcode').attr('value', place.AddressDetails.Country.AdministrativeArea.Locality.PostalCode.PostalCodeNumber);
    				}
                }
				else if (place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea) {
                    if (place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName)
    				{
    					$('#city').attr('value', place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName);
    				}
                    if (place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.PostalCode.PostalCodeNumber)
    				{
    					$('#postalcode').attr('value', place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.PostalCode.PostalCodeNumber);
    				}
                }
				else if (place.AddressDetails.Country.AdministrativeArea.PostalCode) {
                    $('#postalcode').attr('value', place.AddressDetails.Country.AdministrativeArea.PostalCode.PostalCodeNumber);
                }
			}
		}

        function initialize() {
			if (GBrowserIsCompatible()) {
				map = new GMap2(document.getElementById("map_canvas"));
				map.setCenter(new GLatLng(default_lat, default_lng), default_zoom);
				geocoder = new GClientGeocoder();
				map.addControl(new GSmallMapControl());
				map.addControl(new GMapTypeControl());
			}
		}

		$(document).ready(function(){
            $('#email').focus();

            var map = null;
            var geocoder = null;

			initialize();

            var mandatoryFieldIds = new Array("email", "password", "password_again", "address");

            $('#signup').click(function(event){
                event.preventDefault();
                //showLocation();
                $('div.signuperrorbox').hide();
                if (!CheckEmptyGroup(mandatoryFieldIds)) 
                {
                    if (IsValidEmail('email')) 
                    {
                        if ($('#password').attr('value') == $('#password_again').attr('value')) 
                        {
                            $('#responseContainer').load('signupHandler.php?checkemail=1', 
                                                         {email: $('#email').attr('value')}, 
                                                         function(){
                                                         
                                     if ($('#responseContainer').html() == "success") 
                                     {
                                         $('#frm_signup').submit();
                                     }
                                     else 
                                     {
                                            showNotification("The email address you entered is already registered. Please use a different email address.", 0);
                                            return;
                                            
                                     }
                                 })
                        }
                        else
                        {
                            showNotification("Please provide matching passwords.", 0);
                            return;
                        }
                    }
                    else
                    {
                        showNotification("Please enter a valid e-mail address.", 0);
                        return;
                    }
                }
                else
                {
                    showNotification("Please fill up all the fields.", 0);
                    return;
                }
            })

            $('#address').blur(function(){
                showLocation();
            })

            $('#address').keydown(function(){
                //hideNotification();
                clearTimeout(mapTimeoutReference);
                mapTimeoutReference = setTimeout("showLocation()", 1000);
            })

            $('#email, #password, #password_again').keydown(function(){
                //hideNotification();
            })
	
		})
	</script>
</head>

<body>
	<?php include('regularheader.php'); ?>
	<div class="content"> 
		<div class="fullcolumn">
			<h1>Sign Up</h1>
			<div style="width: 50%; float: left;">
				<form id="frm_signup" name="frm_signup" method="POST" action="confirmemail.php">
					<table class="formtable" style="width: 90%">
						<tr>
							<td class="formlabel" style="width: 29%"><label for="email">E-mail:</label></td>
							<td colspan="2"><input id="email" name="email" 
								type="text" style="width: 100%" maxlength="40"/></td>
						</tr>
						<tr>
							<td class="formlabel"><label for="password">Password:</label></td>
							<td colspan="2"><input id="password" name="password" 
								type="password" style="width: 100%"/>
							</td>
						</tr>
						<tr>
							<td class="formlabel"><label for="password_again">Password Again:</label></td>
							<td colspan="2"><input id="password_again" name="password_again" 
								type="password" style="width: 100%"/>
							</td>
						</tr>
						<tr>
							<td class="formlabel"><label for="address">Address or Postal Code:</label></td>
							<td><input id="address" name="address" 
								type="text" style="width: 100%"/>
							</td>
						</tr>
						<tr>
							<td colspan="3" style="text-align: center; padding: 10px;"><input 
							id="signup" name="signup" type="submit" 
							class="btnmakeover btnyes" value="Sign Up"></td>
						</tr>
					</table>
					<input class="hidden" id="city" name="city" type="text"/>
					<input class="hidden" id="province" name="province" type="text"/>
					<input class="hidden" id="postalcode" name="postalcode" type="text"/> 
					<input class="hidden" id="lat" name="lat" type="text"/> 
					<input class="hidden" id="lng" name="lng" type="text"/>
				</form>
			</div>
			<div style="width: 50%; margin-left: 50%;">
				<div id="map_canvas" style="width: 380px; height: 300px; border: solid;"></div>
			</div>
            <div class="signuperrorbox hidden">
            <p id="error_message"></p>
            </div>
            <div id="responseContainer" class="hidden"></div>
		</div>
	</div>
</body>
</html>
