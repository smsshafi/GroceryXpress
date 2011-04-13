<?php include 'regularloginheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>
<?php
    if (isset($_POST['address']) && $_POST['address'] != "") {
        if (!isset($_POST['subscription']) || $_POST['subscription'] == "") {
            $_POST['subscription'] = 0;
        }
        else
        {
            $_POST['subscription'] = 1;
        }
        $_POST['id'] = $_SESSION['userid'];

        UpdateUser($_POST);
    }
    $lastname = GetUserLastNameFromID($_SESSION['userid']);
    $firstname = GetUserFirstNameFromID($_SESSION['userid']);
    $address = GetUserAddressFromID($_SESSION['userid']);
    $subscription = GetUserSubscribedFromID($_SESSION['userid']);
	$store_id = GetUserStoreFromID($_SESSION['userid']);
	$stores = GetStores();

?>
<?php $page_title = 'My Account'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	<?php echo $sCssFile.$sJQueryFile.$sCommonJsFile.$sNotificationJsFile; ?>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAACbE9got-Ty4wRjiRSSNBDRTSips-EQlAUONoGqj0ZBB2PknwtRSwYV_QfPVLJ2QyMimN_nEp3O8vFg" type="text/javascript"></script>
    
	<script type="text/javascript">
                                   
        var store_id = "<?php echo $store_id;?>";
        var user_id = <?php echo $_SESSION['userid'];?>;                           
        var storeJSON = <?php echo GetStoresJSON(); ?>;
        
        var closestStoreListener;
        

        function directionErrors() {
            if (typeof closestStoreListener != 'undefined') {
                removeClosestStoreListener();
            }
            showNotification("We're sorry. We could not find a store close to your home address. Please try using a different address.");
        }

        function findClosestStore() {
            
            removeClosestStoreListener()
            $.post('useraccounthandler.php?findcloseststore=1', 
                   {'lat': $('#lat').attr('value'), 'lng': $('#lng').attr('value')}, 
                   function(response){

                     var responseJSON = eval('(' + response + ')');
                     
                     $('#store_id').attr('value', responseJSON.id);
                     showNotification('Your default store has been set to your closest store.');
                     removeClosestStoreListener();
                     redraw_directions();
                     $.post('useraccounthandler.php?save=1', {'id': user_id, 
                                                         'address': $('#address').attr('value'),
                                                         'city': $('#city').attr('value'),
                                                         'province': $('#province').attr('value'),
                                                         'lat': $('#lat').attr('value'),
                                                         'lng': $('#lng').attr('value'),
                                                         'postalcode': $('#postalcode').attr('value'),
                                                         'store_id': $('#store_id').attr('value')
                                                         },
                    function(response){})
            })
        }

        function updateAddress() {
                
                
                $('#lng').attr('value', '');
                $('#lat').attr('value', '');
                $('#city').attr('value', '');
                $('#province').attr('value', '');
                $('#postalcode').attr('value', '');

				place = directions.getGeocode(0);
				point = new GLatLng(place.Point.coordinates[1],
									place.Point.coordinates[0]);
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

		$(document).ready(function(){
            
            var map = null;
            var geocoder = null;
            var loadlistener;
            var errorlistener;
            var closestStoreListener;
            var user_id = <?php echo $_SESSION['userid'];?>;
            var mapTimeoutReference;

			initialize();
            updateStoreInfo();

            $('#signup').click(function(){
                window.location = 'signup.php';
            })

            $('#address').keydown(function(){
                clearTimeout(mapTimeoutReference);
                mapTimeoutReference = setTimeout("redraw_directions()", 1000);
            })

			$('#store_id').change(function(){
                redraw_directions();
                updateStoreInfo();
            })

            $('#suggest').click(function(){
                AddClosestStoreListener();
                redraw_directions();
                
            })

            $('#showstoreinfo').toggle(
                function(){
                    $('#store_info').slideDown(function(){
                        $('#showstoreinfo').attr('value', 'Hide Store Information');
                        $('html, body').animate({scrollTop: $('#store_info').offset().top}, 500);
                        
                    });
                    
                },
                function(){
                     $('#store_info').slideToggle();
                     $('#showstoreinfo').attr('value', 'Show Store Information');
                     $('html, body').animate({scrollTop: 0}, 500, 
                        function(){
                             $('#store_info').slideUp();
                             $(this).attr('value', 'Show Store Information');
                        });
                }
            )

            $('#showdrivingdirections').toggle(
                function(){
                    $('#driving_directions').slideDown(function(){
                        $('#showdrivingdirections').attr('value', 'Hide Driving Directions');
                        $('html, body').animate({scrollTop: $('#driving_directions').offset().top}, 500);
                    });
                    
                },
                function(){
                    $('html, body').animate({scrollTop: 0}, 500, 
                        function(){
                             $('#driving_directions').slideUp();
                             $('#showdrivingdirections').attr('value', 'Show Driving Directions');
                        });

                    }
            )

			$('#save').click(function(event){
                event.preventDefault();
                if (CheckEmpty('address')) {
                    showNotification("You must enter an address.");
                    $('#address').focus();
                    return;
                }
                
                $.post('useraccounthandler.php?save=1', {'id': user_id, 
                                                         'lastname': ($('#lastname').attr('value') || ""), 
                                                         'firstname': ($('#firstname').attr('value') || ""),
                                                         'address': $('#address').attr('value'),
                                                         'subscription': $('#subscription').attr('checked'),
                                                         'city': $('#city').attr('value'),
                                                         'province': $('#province').attr('value'),
                                                         'lat': $('#lat').attr('value'),
                                                         'lng': $('#lng').attr('value'),
                                                         'postalcode': $('#postalcode').attr('value'),
                                                         'store_id': $('#store_id').attr('value')
                                                         },
                function(response){
                    responseJSON = eval('(' + response + ')');
                    showNotification(responseJSON.message);
                })
            })
        })

        function redraw_directions() {
            directions.load("from: " + $("#address").attr('value') + " to: " + storeJSON[$('#store_id').attr('value')].address);
        }

        function updateStoreInfo() {
			$('#phone').html("Phone: " + storeJSON[$('#store_id').attr('value')].phone);
        }

        function addDefaultListeners() {
            loadlistener = GEvent.addListener(directions, "load", updateAddress);
            errorlistener = GEvent.addListener(directions, "error", directionErrors);
        }

        function AddClosestStoreListener() {
            closestStoreListener = GEvent.addListener(directions, "load", findClosestStore);
        }

        function removeClosestStoreListener() {
            GEvent.removeListener(closestStoreListener);
        }

        function initialize() {
			if (GBrowserIsCompatible()) {
                map = new GMap2(document.getElementById("map_canvas"));
                map.setCenter(new GLatLng(default_lat, default_lng), default_zoom);
                directionsPanel = document.getElementById("route");
                directions = new GDirections(map, directionsPanel);
				geocoder = new GClientGeocoder();
				map.addControl(new GSmallMapControl());
				map.addControl(new GMapTypeControl());
                addDefaultListeners();
                redraw_directions();
                $('#driving_directions').hide();
                if (store_id == "" || store_id == 0) {
                    $.post('useraccounthandler.php?updatestore=1', {'id': user_id, 
                                                         'store_id': $('#store_id').attr('value')
                                                         })

                    AddClosestStoreListener();
                    redraw_directions();
                }
			}
		}
	</script>
</head>

<body>
	<?php include('regularheader.php'); ?>
	<div class="content"> 
		<div class="fullcolumn">
			<h1><?php echo $page_title; ?></h1>
			<form id="frm_account" name="frm_account" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <table class="formtable" style="width: 100%">
					
					<tr>
						<td class="formlabelleft">
							<label for="lastname">
							Last name:</label></td>
						<td><input id="lastname" name="lastname" 
							type="text" value="<?php echo $lastname; ?>"/></td>
						<td class="formlabelleft">
							<label for="firstname">
							First 
							name:</label></td>
						<td><input id="firstname" name="firstname" 
							type="text" value="<?php echo $firstname; ?>"/></td>
                                <td colspan="4" class="formlabel" style="text-align: left;"> 
						<input name="subscription" id="subscription" type="checkbox" 
						<?php
							 if ($subscription == 1) {
								 echo ' checked="true"';
                             }
					    ?>
							
							/>
						<label for="subscription"> Subscribe to flyers and
								other information</label> 
						</td>
					</tr>
					
				</table>
				<table class="formtable" style="width: 100%">
					<tr>
						<td class="formlabelleft"><label for="address">Home Address</label></td>
								
					</tr>
					<tr>
						<td style="padding-right: 15px; width: 78%;">
							<input type="text" id="address" name="address"
							style="width: 92%" value="<?php echo $address; ?>"/></td>
						
					</tr>
						
				</table>
				<table class="formtable" style="width: 100%">
					<tr>
						<td class="formlabelleft"><label for="store_id">Preferred Store Address</label></td>
					</tr>
					<tr>
						<td style="padding-right: 15px; width: 78%;">
							<select id="store_id" name="store_id" style="width: 102%">
							<?php
								while ($row = mysql_fetch_assoc($stores))
								{
									if ($row['id'] == $store_id) {
										echo '<option value="'.$row[ 'id'].'" selected="true">'.GetStoreNameFromID($row['id']).' - '.GetStoreCityFromID($row['id']).' - '.GetStoreAddressFromID($row['id']).'</option>';
									}
									else
									{
										echo '<option value="'.$row['id'].'">'.GetStoreNameFromID($row['id']).' - '.GetStoreCityFromID($row['id']).' - '.GetStoreAddressFromID($row['id']).'</option>';
									}
								}
							?>
							</select>
						</td>
						<td style=""><input type="button" 
						id="suggest" name="suggest" value="Find nearest" 
						class="btnmakeover btnsearch"/></td>
					</tr>
                                <tr><td><input id="showstoreinfo" type="button" value="Show Store Information" class="btntextonly"/>
                                <input id="showdrivingdirections" class="btntextonly" type="button" value="Show Driving Directions"/></td><td></td></tr>
                    
						
				</table>
                <table class="formtable" style="width: 100%">
                     <tr>
						<td style="text-align: center; width: 100%;"><input 
						type="button" value="Save Changes" id="save" name="save" 
						class="btnmakeover btnyes btndarker"/></td>
					</tr>
                </table>
                                
				<div id="store_info" style="font-size: 85%; border: dashed 2px black; margin-left: 10px; margin-right: 10px; margin-bottom: 10px; padding-left: 10px;" class="hidden">
					<p>
						Hours:
						<br/> Weekdays: 8AM - 9PM<br/> Weekends: 9AM - 6PM<br/>
						Holidays: Closed<br/> 
						<p id="phone"></p>
						</p>
				</div>
                                
                <div id="driving_directions">
                    <table>
                                <tr><td style="vertical-align: top">
        				<div id="map_canvas" style="width: 455px; height: 350px; border: solid; margin-left: 2%;"></div>
                                </td>
                                <td style="vertical-align: top">
        				<div id="route" style="margin-right: 5px; font-size: 70%; width: 300px; padding-top: 0px; margin-top: -13px;">
                                </td>
                        </div>
                    </table>
					
				</div>
                                
				
				<input class="hidden" id="city" name="city" type="text"/>
				<input class="hidden" id="province" name="province" type="text"/>
				<input class="hidden" id="postalcode" name="postalcode" type="text"/> 
				<input class="hidden" id="lat" name="lat" type="text"/> 
				<input class="hidden" id="lng" name="lng" type="text"/>
			</form>
		</div>
	</div>
</body>
</html>
