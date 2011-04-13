<?php include 'masteradminonly.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php $page_title = 'Modify Stores'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php echo $sAdminCssFile.$sAllJs; ?>
		<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
		<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAACbE9got-Ty4wRjiRSSNBDRTSips-EQlAUONoGqj0ZBB2PknwtRSwYV_QfPVLJ2QyMimN_nEp3O8vFg" type="text/javascript"></script>
		<script type="text/javascript">
			
			function GenerateFormTableMapping( )
			{
				return {
					id: $('#masterDropDown').attr('value'),
					name: $('#xname').attr('value'), 
					address: $('#xaddress').attr('value'), 
					city: $('#xcity').attr('value'),
					phone: $('#xphone').attr('value'),
                    postalcode: $('#xpostalcode').attr('value'),
					province: $('#xprovince').attr('value'),
					lat: $('#xlat').attr('value'),
					lng: $('#xlng').attr('value')
				};
			}

			function PopulateReturnURL(id)
			{
				if (!id)
				{
					id = $('#masterDropDown').attr('value'); 
				}
				
				$('#returnURL').attr('value', '<?php echo $_SERVER['PHP_SELF']; ?>' + '?id=' + id);
			}

            function ZeroLongLat()
            {
				if ($('#xlat').attr('value') == "" || $('#xlat').attr('value') == null)
                {
					$('#xlat').attr('value', '0');
                }

                if ($('#xlng').attr('value') == "" || $('#xlng').attr('value') == null)
                {
					$('#xlng').attr('value', '0');
                }
            }

            // addAddressToMap() is called when the geocoder returns an
            // answer.  It adds a marker to the map with an open info window
            // showing the nicely formatted version of the address and the country code.
            function addAddressToMap(response) {
                map.clearOverlays();
                if (!response || response.Status.code != 200) 
                {
                    alert("Sorry, we were unable to geocode that address");
                } 
                else 
                {
                    $('#xlng').attr('value', '');
                    $('#xlat').attr('value', '');
                    $('#xcity').attr('value', '');
                    $('#xprovince').attr('value', '');
                    $('#xpostalcode').attr('value', '');
                    place = response.Placemark[0];
                    point = new GLatLng(place.Point.coordinates[1],
                    					place.Point.coordinates[0]);
                    marker = new GMarker(point);
                    map.addOverlay(marker);
                    marker.openInfoWindowHtml(place.address);
					$('#xlng').attr('value', place.Point.coordinates[0]);
                    $('#xlat').attr('value', place.Point.coordinates[1]);
					if (place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName)
    				{
    					$('#xprovince').attr('value', place.AddressDetails.Country.AdministrativeArea.AdministrativeAreaName);
    				}
    				else
    				{
    					$('#xprovince').attr('value', '');
    				}
                    if (place.AddressDetails.Country.AdministrativeArea.Locality)
                    {
        				if (place.AddressDetails.Country.AdministrativeArea.Locality.LocalityName)
        				{
        					$('#xcity').attr('value', place.AddressDetails.Country.AdministrativeArea.Locality.LocalityName);
        				}
    
                        if (place.AddressDetails.Country.AdministrativeArea.Locality.PostalCode.PostalCodeNumber)
        				{
        					$('#xpostalcode').attr('value', place.AddressDetails.Country.AdministrativeArea.Locality.PostalCode.PostalCodeNumber);
        				}
                    }
    				else if (place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea) {
                        if (place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName)
        				{
        					$('#xcity').attr('value', place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.LocalityName);
        				}
                        if (place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.PostalCode.PostalCodeNumber)
        				{
        					$('#xpostalcode').attr('value', place.AddressDetails.Country.AdministrativeArea.SubAdministrativeArea.Locality.PostalCode.PostalCodeNumber);
        				}
                    }
    				else if (place.AddressDetails.Country.AdministrativeArea.PostalCode) {
                        $('#xpostalcode').attr('value', place.AddressDetails.Country.AdministrativeArea.PostalCode.PostalCodeNumber);
                    }
                }
            }
            
            // showLocation() is called when you click on the Search button
            // in the form.  It geocodes the address entered into the form
            // and adds a marker to the map at that location.
            function showLocation() {
                var address = $('#xaddress').attr('value');
                geocoder.getLocations(address, addAddressToMap);
            }
            
            // findLocation() is used to enter the sample addresses into the form.
            function findLocation(address) {
                document.forms[0].q.value = address;
                showLocation();
            }

            function showAddress(address) {
              geocoder.getLatLng(
                address,
                function(point) {
                  if (!point) {
                    alert(address + " not found");
                  } else {
                    map.setCenter(point, 13);
                    var marker = new GMarker(point);
                    map.addOverlay(marker);
                    marker.openInfoWindowHtml(address);
                  }
                }
              );
            }

            // showLatLngOnMap() is called when the Master Drop Down is changed.
            // It retrieves the lat/lng saved in the database and maps it
            function showLatLngOnMap() {
                map.clearOverlays();
                point = new GLatLng($('#xlat').attr('value'), $('#xlng').attr('value'));
                marker = new GMarker(point);
                map.addOverlay(marker);
                marker.openInfoWindowHtml($('#xaddress').attr('value'));
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

            function clearOverlays() {
                map.clearOverlays();
            }

            $(document).ready(function(){
			
                var map = null;
                var geocoder = null;
                
				initialize();

				var requestHandler = 'storehandler.php';
				var mandatoryFieldIds = new Array('xname', 'xaddress');
				var currentEditRequest = "<?php if (isset($_GET['id'])) {echo $_GET['id'];}?>";
				var addRequest = "<?php if (isset($_GET['add'])) {echo $_GET['add'];}?>";

                $('#xaddress').blur(function(){
                    showLocation();
                });

				$('#lookup').click(function(){
                    showLocation();
                });
                
				$(document).ajaxStart(function(){
					AjaxStart();
				});

				$(document).ajaxSuccess(function(){
					AjaxSuccess();
				});

				$(document).ajaxError(function(){
					AjaxError();
				});

				RepopulateMasterDropDown(requestHandler, currentEditRequest);

				InitializeAdd();
				
				$('#masterDropDown').change(function () {
					MasterDropDownChange($(this).attr('value'), requestHandler, PopulateReturnURL, showLatLngOnMap);
					if ($(this).attr('value') == null)
                    {
						clearOverlays();
                    }
				})

				$('#edit').click(function(){
					ZeroLongLat();
					GenericEdit(mandatoryFieldIds, requestHandler);
				})
				
				$('#delete').click(function(){
					$.blockUI({ message: $('#question'), css: { width: '275px' } });
				})

				$('#yes').click(function(){
					GenericDelete(requestHandler);
                    InitializeAdd();
                    clearOverlays();
				})
		
				$('#no').click($.unblockUI);
				
				$('#showAdd').click(function(){
					InitializeAdd();
                    clearOverlays();
				})

				$('#add').click(function(){
                    ZeroLongLat();
					GenericAdd(mandatoryFieldIds, requestHandler);
                    clearOverlays();
				})

				if (currentEditRequest)
				{
					MasterDropDownChange(currentEditRequest, requestHandler, showLatLngOnMap);  //pre-select requested value if started in edit mode
					PopulateReturnURL(currentEditRequest);
				}

				if (addRequest)
				{
					InitializeAdd();
				}
			})
			
		</script>
	</head>
	<body onunload="GUnload()">
	<div class="content">
		
		<?php include 'uwheader.php'; ?>
		<p class="pagetitle"><?php echo $page_title; ?></p>
		<form class="hidden" id="frm_returnURL" action="" method="post">
			<input type="text" id="returnURL" name="returnURL"/>
		</form>
		
		<form id="frm_editdelete">
			
			<fieldset class="crud">
				<legend>What would you like to do?</legend>
				<input type="button" id="showAdd" class="btnadd btnmakeover" value="Add a new store"/>
				<label for="masterDropDown">or modify an existing 
					store:</label>
				<select id="masterDropDown" class="masterDropDown">
				</select>
			</fieldset>
			
			<div id="slidingInformation" class="nopadding">	
				<fieldset id="changer" class="crud">
					<legend>Store Information</legend>
					<div class="insidecrudleft" style="width: 64%">
						<div id="map_canvas" style="width: 450px; height: 400px; border: solid;"></div>
					</div>
					<div class="insidecrudright" style="width: 34%">
						<p>	
							<label for="xname">Name:</label><br/>
							<input type="text" id="xname" name="xname"/> 
						</p>
						<p>	
							<label for="xaddress">Address:</label><br/>	<input
							type="text" id="xaddress" name="xname" style="width:
							90%"/><br/> <input class="btnmakeover btnsearch" 
							type="button" id="lookup" name="lookup" 
							value="Locate on Map"/>
						</p>
						<p class="hidden">	
							<label for="xcity">City:</label><br/>
							<input type="text" id="xcity" name="xcity"/>
						</p>
						<p class="hidden">	
							<label for="xprovince">Province:</label><br/>
							<input type="text" id="xprovince" name="xprovince"/>
						</p>
						<p class="hidden">	
							<label for="xpostalcode">Postal Code:</label><br/>
							<input type="text" id="xpostalcode" 
							name="xpostalcode"/>
						</p>
						<p>	
							<label for="xphone">Phone Number:</label><br/>
							<input type="text" id="xphone" 
							name="xphone"/>
						</p>
						<p class="hidden">	
							<label for="xlat">Latitude:</label><br/>
							<input type="text" id="xlat" 
							name="xlat"/>
						</p>
						<p class="hidden">	
							<label for="xlng">Longitude:</label><br/> <input 
							type="text" id="xlng" name="xlng"/>
						</p>
					</div>
					<div class="insidecrudbottom">
						<input type="button" id="add" class="btnadd btnmakeover" 
						value="Add this store"/> <input type="button" 
						id="edit" class="btnedit btnmakeover" 
						value="Save Changes"/> <input type="button" id="delete" 
						class="btndelete btnmakeover" 
						value="Delete this store"/>
						<div class="messageWrapper">
							<div href="#message" id="message" class="message"></div>
						</div>
					</div>
				</fieldset>
			</div>
			<div class="messageWrapper">
					<div id="message" class="message"></div>
				</div>
			<div id="responseContainer" class="hidden"></div>

			<div id="question" class="hidden"> 
				<div class="dialogbox">Are you sure you want to delete this 
				store?</div> <input type="button" id="yes" 
				class="btnyes btnmakeover" value="Yes" /> <input type="button" 
				id="no" class="btnno btnmakeover" value="No" /> 
			</div>
			<div id="hit" class="hidden"></div> 

		</form>
		<?php include 'previousPage.php'; ?>
	</div>
	
	</body>
</html>


