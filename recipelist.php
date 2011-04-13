
<?php
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
        
        $image_url = $row['image'];
        $title = $row['name'];
		$id = $row['id'];
        $quantity = 0;

        include 'recipewidget.php';
    }
}
?>
