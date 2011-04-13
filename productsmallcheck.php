<?php
$shoppinglistintegration = false;
if (isset($context)) {
    
    if (($context == "search" || $context == "featuredproducts") && isset($logged_in) && $logged_in == true) {
        $shoppinglistintegration = true;
    }
}
?>

<div class="product_small" id="div_<?php echo $id; ?>">
	<div class="hidden" id="product_title_<?php echo $id ; ?>"><b><?php echo $full_title; ?></b></div>
	<div class="hidden" id="product_description_<?php echo $id ; ?>"><?php echo $full_desc; ?></div>
    <?php if (!$shoppinglistintegration) { ?>
                        
    <?php
    }
    else
    {
        ?>
                        <table style="width: 100%;">
                            <tr>
                            	<td rowspan="3" style="width: 10px"><input type="button" class="btnimageonly btncheck" id="check_<?php echo $id ; ?>" name="check" title="Picked Up"/></td>
                                <td rowspan="2" style="width: 10%;" class="product_image_td">
                                	<img id="product_image_<?php echo $id ; ?>"	class="product_image" src="<?php echo $sWebRoot."/".$image_url; ?>" style="width: 60px; max-height: 70px;"/>
                                </td>
                                <td class="product_title_td" style="width: 50%;">
                                	<b><?php echo $title; ?></b>
                                </td>
                                <td class="product_price" id="product_price_<?php echo $id ; ?>" rowspan="3" style="width: 20%; text-align: right; font-size: 170%; padding-left: 20px;">
                                    <?php
										 if (isset($saleprice) && $saleprice != 0) {
											 echo '<span style="font-size: 65%; text-align: right;"><del>'.Currencize($price).'</del></span><br/>';
                                         }
									?>
									<?php
										 if (isset($saleprice) && $saleprice != 0) {
											 echo Currencize($saleprice);
                                         }
										 else
                                         {
											 echo Currencize($price);
                                         }
									?>
								</td>
                                <td class="tdadd<?php if ($quantity != 0) {echo ' hidden';} ?>" id="tdadd<?php echo $id; ?>" rowspan="3" style="text-align: center; height: 69px; ">
                                    <input title="Add to shopping list" type="button" class="btnimageonly sladd" id="sladd_<?php echo $id; ?>"/>
                                </td>
                                <td class="tdupdate<?php if ($quantity == 0) {echo ' hidden';} ?>" id="tdupdate<?php echo $id; ?>" rowspan="3" style="text-align: center">
                                    <input type="button" class="btnimageonly btndelete sldecrement" id="sldecrement_<?php echo $id; ?>"/> 
                                    <input type="button" style="width: 20px; height: 27px; text-align: center" value="<?php if ($quantity == 0) {echo '1';} else {echo $quantity;} ?>" class="slquantity" id="slquantity_<?php echo $id; ?>"/>
                                    <input type="button" class="btnadd btnimageonly slincrement" id="slincrement_<?php echo $id; ?>"/>
									<br/>
                                    <input title="Remove from shopping list" type="button" style="margin-top: 5px;" class="btnimageonly slremove" id="slremove_<?php echo $id; ?>"/>                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 80%; text-align: justify;">
                                	<?php echo nl2br($desc); ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 80%" colspan="2">
                                <?php 
                                	echo "Aisle ".$aisle_number; 
                                	if (isset($aisle_position) && $aisle_position != "") {
                                		if ($aisle_position >= 5) {
                                			echo " (back)";
                                		}
                                		else
                                		{
                                			echo " (front)";
                                		}
                                         
                                    }
                                    echo " - ".$aisle_name; ?></td>
                            </tr>
                        </table>
    <?php
    }
    ?>
                    </div>