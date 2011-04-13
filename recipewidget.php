<div class="recipe_small" id="div_<?php echo $id; ?>">
    <table style="width: 100%;">
        
        <tr>
            <td style="width: 10%;"> <a 
                 href="showrecipe.php?id=<?php echo 
                $id;?>"><img id="recipe_image_<?php echo $id ; ?>" 
                class="recipe_image" src="<?php echo $sWebRoot."/".$image_url; 
                ?>"/></a>
            </td>
            <td id="recipe_title_<?php echo $id ; ?>" style="width: 
                90%;"><a 
                 href="showrecipe.php?id=<?php echo 
                $id;?>"><b><?php echo $title; ?></b></a>
            </td>
        </tr>
        
    </table> 
</div>

