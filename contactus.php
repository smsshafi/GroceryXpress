<?php include 'regularloginoptionalheader.php'; ?>
<?php include 'siteconfig.php'; ?>
<?php include_once 'etc.php'; ?>

<?php $page_title = 'Contact Us'; ?>
<?php echo $sDocType; ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo $sTitle . ' ~ ' . $page_title; ?></title>
	<?php echo $sCssFile.$sJQueryFile.$sCommonJsFile.$sNotificationJsFile; ?>
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAACbE9got-Ty4wRjiRSSNBDRTSips-EQlAUONoGqj0ZBB2PknwtRSwYV_QfPVLJ2QyMimN_nEp3O8vFg" type="text/javascript"></script>
    
	<script type="text/javascript">
        var storeJSON = <?php echo GetStoresJSON(); ?>;                     
        // showLocation() is called when you click on the Search button
		// in the form.  It geocodes the address entered into the form
		// and adds a marker to the map at that location.
		function showLocation() {
            
            var address = storeJSON[$('#store_id').attr('value')].address;
            if (address != null) {
                geocoder.getLocations(address, addAddressToMap);
            }
		}

        function updateStoreInfo() {
			if ($('#store_id').attr('value')) {
				$('#store_info').show();
                $('#phone').html("Phone: " + storeJSON[$('#store_id').attr('value')].phone);
            }
			else
            {
                $('#store_info').hide();
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
                
				place = response.Placemark[0];
				point = new GLatLng(place.Point.coordinates[1],
									place.Point.coordinates[0]);
				marker = new GMarker(point);
				map.addOverlay(marker);
				marker.openInfoWindowHtml(place.address);
				
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
            
            var map = null;
            var geocoder = null;
            var loadlistener;
            var errorlistener;

			initialize();
            updateStoreInfo();

            
			$('#store_id').change(function(){
                showLocation();
                updateStoreInfo();
            })
        })
	</script>
</head>

<body>
	<?php include('regularheader.php'); ?>
	<div class="content"> 
		<div class="fullcolumn">
			<h1><?php echo $page_title; ?></h1>
			
			<div style="width: 720px; padding: 10px 40px 20px 40px;">
			<p>E-mail us: info@groceryxpress.net<br/>Call us: 1-800-555-3243</p>
				<table style="margin-bottom: 10px">
				<tr>
					<td>
						<label for="store_id">Find a store:</label>
					</td>
					<td>
						<select id="store_id" name="store_id">
							<option value="">Please select a store...</option>
						<?php
							 $stores = GetStores();
							 while ($row = mysql_fetch_assoc($stores)) {
								 echo '<option value="'.$row['id'].'">'.GetStoreNameFromID($row['id']).' - '.GetStoreCityFromID($row['id']).' - '.GetStoreAddressFromID($row['id']).'</option>';
                             }
                             ?>	
						</select>
					</td>
				</tr>
			</table>
				<div id="map_canvas" style="width: 100%; height: 400px; border: solid;"></div>
				<div id="store_info" style="width: 100%; font-size: 85%; border: dashed 2px black; margin-top: 20px;" class="hidden">
					<p style="margin-left: 20px">
						Hours:
						<br/> Weekdays: 8AM - 9PM<br/> Weekends: 9AM - 6PM<br/>
						Holidays: Closed<br/> 
						<span id="phone"></span>
						</p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
