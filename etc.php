<?php
	include 'secure.php';
	include 'siteconfig.php'; 	

	/*
	Function: SQLConenct

	High-level description: Establishes and returns a MySQL database conenction that can be used by other methods. 

	Low-level description: Uses validation data from included 'secure.inc' file to connect to a MySQL database and select a database. 
	
	Required Arguments: None

	Optional Arguments: None

	Return type: String
	*/
	function SQLConnect()
	{
		global $sql_server, $sql_username, $sql_password, $sql_database;
		$SQLConn = mysql_connect($sql_server, $sql_username, $sql_password);
		mysql_select_db($sql_database, $SQLConn);
		return $SQLConn;
	}
	
	/*
	Function: SQLDisconnect

	High-level description: Closes the MySQL database connection 
	
	Low-level description: Closes the database connection that it was connected to in the SQLConnect() funtion
	
	Required Arguments: Connection string containing information from the "secure.inc" file about the sql_server, sql_username and sql_password

	Optional Arguments: None

	Return type: None
	*/
	function SQLDisconnect($SQLConn)
	{
		mysql_close($SQLConn);
	}
	
	/*
	=================================================
		Start Aisles functions
	*/
	
	/*
	Function: GetTerms

	High-level description: Selects the academic terms in ascending order from the "term" table
	
	Low-level description: Queries all the data associated with a given term in ascending order based on the id and returns the result as a string
	
	Required Arguments: None

	Optional Arguments: None

	Return type: String
	*/
	function GetAislesFromStoreID($store_id)
	{
		return GetRowsFromTable('fydp_aisles', 'store_id', $store_id);
	}

	function AddAisle($values)
	{
		return AddEntryToTable('fydp_aisles', $values);
	}
	
	function GetAisleFromID($id)
	{
		return GetRowFromTableGivenID('fydp_aisles', $id);
	}

	function GetAisleNameFromID($id)
	{
		return GetCellFromTableGivenID('fydp_aisles', 'name', $id);
	}

	function GetAisleNumberFromID($id)
	{
		return GetCellFromTableGivenID('fydp_aisles', 'number', $id);
	}

	function DeleteAisleFromID($id)
	{
		return DeleteRowFromTableGivenID('fydp_aisles', $id);
	}

	function UpdateAisle($values)
	{
		return UpdateEntryInTable('fydp_aisles', $values);
	}

	/*
		End Aisles functions
	=================================================
	*/
    
	
	/*
	=================================================
		Start Category functions
	*/
	
	/*
	Function: GetSets

	High-level description: Selects all the sets from the "question_sets" table
	
	Low-level description: Queries all the data from the "question_sets" table of the database it is connected to
	
	Required Arguments: None

	Optional Arguments: None

	Return type: String
	*/
	function GetCategories()
	{
        $SQLConn = SQLConnect();
        $result = mysql_query("SELECT fydp_categories.name, (SELECT COUNT(*) FROM fydp_products WHERE fydp_products.category_id = fydp_categories.id) AS count FROM fydp_categories ORDER BY name ASC;");
        echo mysql_error();
        SQLDisconnect($SQLConn);
        return $result;
	}

	function AddCategory($values)
	{
		return AddEntryToTable('fydp_categories', $values);
	}
	
	function GetCategoryFromID($id)
	{
		return GetRowFromTableGivenID('fydp_categories', $id);
	}

	function GetCategoryNameFromID($id)
	{
		return GetCellFromTableGivenID('fydp_categories', 'name', $id);
	}

	function DeleteCategoryFromID($id)
	{
		return DeleteRowFromTableGivenID('fydp_categories', $id);
	}

	function UpdateCategory($values)
	{ 
		return UpdateEntryInTable('fydp_categories', $values);
	}

    /*
		End Set functions
	=================================================
	*/

	/*
	=================================================
		Start SubCategories functions
	*/
	
	function GetSubCategories()
	{
		return GetAllFromTableSort('fydp_subcategories', 'name');
	}

	function GetSubCategoryFromID($id)
	{
		return GetRowFromTableGivenID('fydp_subcategories', $id);
	}

	function GetSubCategoryNameFromID($id)
	{
		return GetCellFromTableGivenID('fydp_subcategories', 'name', $id);
	}

	function AddSubCategory($values)
	{
		return AddEntryToTable('fydp_subcategories', $values);
	}
	
	function UpdateSubCategory($values)
	{
		return UpdateEntryInTable('fydp_subcategories', $values);
	}
	
	function DeleteSubCategoryFromID($id)
	{
		return DeleteRowFromTableGivenID('fydp_subcategories', $id);
	}

	/*
		End SubCategories functions
	=================================================
	*/
	
    /*
	=================================================
		Start User functions
	*/

    function GetUserDataFromID($id) {
        return GetRowFromTableGivenID('fydp_users', $id);
    }

    function GetUserLastNameFromID($id) {
        $result = GetUserDataFromID($id);
        $row = mysql_fetch_assoc($result);
        return $row['lastname'];
    }

    function GetUserFirstNameFromID($id) {
        $result = GetUserDataFromID($id);
        $row = mysql_fetch_assoc($result);
        return $row['firstname'];
    }

    function GetUserSubscribedFromID($id) {
        $result = GetUserDataFromID($id);
        $row = mysql_fetch_assoc($result);
        return $row['subscription'];
    }

    function GetUserAddressFromID($id) {
        $result = GetUserDataFromID($id);
        $row = mysql_fetch_assoc($result);
        return $row['address'];
    }

    function GetUserStoreFromID($id) {
        $result = GetUserDataFromID($id);
        $row = mysql_fetch_assoc($result);
        return $row['store_id'];
    }

    function GetUserPasswordFromEmail($email) {
        $id = GetUserIDFromEmail($email);
        if ($id)
        {
            return GetCellFromTableGivenID('fydp_users', 'password', $id);
        }
        return false;
    }

    function GetUserIDFromEmail($email) {
        $result = GetRowsFromTable('fydp_users', 'email', $email);
        if (mysql_num_rows($result) == 0)
        {
            return false;
        }
        $row = mysql_fetch_assoc($result);
        return $row['id'];
    }

    function CheckUniqueUserEmail($email) {
        $result = GetRowsFromTable('fydp_users', 'email', $email);
        if (mysql_num_rows($result) > 0) {
            return false;
        }
        else
        {
            return true;
        }
    }

    function GetUserEmailFromID($id) {
        return GetCellFromTableGivenID('fydp_users', 'email', $id);
    }

    function AddUser($values)
    {
        unset($values['password_again']);
        foreach ($values as $key=>$value) {
            if ($value == "")
            {
                unset($values[$key]);
            }
        }
        $values['token'] = MakeRandomPassword();
        $values['inactive'] = '1';
        $values['admin'] = '0';
        $values['password'] = md5($values['password']);
        if (!isset($values['firstname']) || $values['firstname'] == "") {
            
            $split_email = split('@', $values['email']);
            $values['firstname'] = $split_email[0];
        }
        
        $id = AddEntryToTable('fydp_users', $values, true);
        
        if (is_integer($id))
        {
            $values['id'] = $id;
            SendSignUpEmail($values);
            AddShoppingList($id);
        }
        
        return $id;
    }

    function ActivateUser($token)
    {
        $result = GetRowsFromTable('fydp_users', 'token', $token);
        if (mysql_num_rows($result) != 1)
        {
            return false;
        }
        $row = mysql_fetch_assoc($result);
        $user_id = $row['id'];
       
        if (UpdateCellGivenID('fydp_users', 'inactive', $user_id, '0'))
        {
            UpdateCellGivenID('fydp_users', 'token', $user_id, null);
            return $user_id;
        }
        else
        {
            return false;
        }
    }

    function SendSignUpEmail($values) {
        global $sWebRoot, $sTitle;
        $subject = "Your confirmation code";
		$body = 
        "
Your confirmation code is: ".$values['token']."\n
Please use this code to complete your sign up process.
If for some reason  you have lost the page in which you enter the confirmation code,
please follow the link below where you will be asked to enter your confirmation code:\n".
$sWebRoot."/confirmemail.php".

"\n\n** This is an automated message. Please do not reply. **";
		$header = "From: ".$sTitle." <noreply@groceryxpress.net>";
		mail($values['email'], $subject, $body, $header);
    }

    function UpdateUser($values)
    {
        return UpdateEntryInTable('fydp_users', $values);
    }

    function AuthenticateRegularUser($email, $password) {
        $email = mysql_escape_string($email);
        $password = mysql_escape_string($password);
        $response['error'] = true;
        $response['message'] = "Unknown error!";
        $correct_password = GetUserPasswordFromEmail($email);
        if ($correct_password && ($correct_password == md5($password)))
        {
            if (IsUserInactive($email) == 0)
            {
                $response['error'] = false;
                $response['message'] = "";
            }
            else
            {
                $response['error'] = true;
                $response['message'] = "Your account is currently inactive. Instructions on how to activate your account have been sent to your inbox. If you can't find instructions there, try signing up again.";
            }
        }
        else
        {
            $response['error'] = true;
            $response['message'] = "The email address and password combination you entered is invalid.";
        }
        return $response;
    }

    function IsUserInactive($email) {
        $email = mysql_escape_string($email);
        $id = GetUserIDFromEmail($email);
        if ($id)
        {
            return GetCellFromTableGivenID('fydp_users', 'inactive', $id);
        }
        return 1;
    }

    /*
		End User functions
	=================================================
	*/

    /*
	=================================================
		Start Stores functions
	*/
	
	function GetStores()
	{
		return GetAllFromTable('fydp_stores');
	}

    function GetStoresJSON()
    {
        $result = GetAllFromTable('fydp_stores');
        if (mysql_num_rows($result) == 0)
        {
            return "{}";
        }
        else
        {
            $JSON = "{";
            $first = true;
            while ($row = mysql_fetch_assoc($result))
            {
                if ($first)
                {
                    $JSON .= '"'.$row['id'].'": {"lat": "'.$row['lat'].'", "lng": "'.$row['lng'].'", "address": "'.$row['address'].'", "phone": "'.$row['phone'].'"}';
                    $first = false;
                }
                else
                {
                    $JSON .= ',"'.$row['id'].'": {"lat": "'.$row['lat'].'", "lng": "'.$row['lng'].'", "address": "'.$row['address'].'", "phone": "'.$row['phone'].'"}';
                }
            }
        }
        $JSON .= "}";
        return $JSON;
    }
    
    function FindNearestStore($lat, $lng) {
        $SQLConn = SQLConnect();
        $result = mysql_query("SELECT id, ( 3959 * acos( cos( radians($lat) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians($lng) ) + sin( radians($lat) ) * sin( radians( lat ) ) ) ) AS distance FROM fydp_stores ORDER BY distance LIMIT 1");
        SQLDisconnect($SQLConn);
        $row = mysql_fetch_assoc($result);
        return '{"id":"'.$row['id'].'"}';
    }

	function GetStoreFromID($id)
	{
		return GetRowFromTableGivenID('fydp_stores', $id);
	}

	function GetStoreNameFromID($id)
	{
		return GetCellFromTableGivenID('fydp_stores', 'name', $id);
	}

    function GetStoreCityFromID($id)
	{
		return GetCellFromTableGivenID('fydp_stores', 'city', $id);
	}

    function GetStoreAddressFromID($id)
	{
		return GetCellFromTableGivenID('fydp_stores', 'address', $id);
	}

    function UpdateStore($values)
	{ 
		return UpdateEntryInTable('fydp_stores', $values);
	}

    function AddStore($values)
	{
		return AddEntryToTable('fydp_stores', $values);
	}

    function DeleteStoreFromID($id)
	{
		return DeleteRowFromTableGivenID('fydp_stores', $id);
	}

    /*  
     
    End Stores functions 
     
    */

    /*
	=================================================
		Start Shopping List functions
	*/

    function AddShoppingList($user_id) {
        $values['user_id'] = $user_id;
        return AddEntryToTable('fydp_lists', $values);
    }

    function AddProductToList($product_id, $user_id, $quantity = 1) {
        if (CheckIfProductInList($product_id, $user_id))
        {
            return IncrementProductInList($product_id, $user_id);
        }
        $list_id = GetListFromUserID($user_id);
        $values['product_id'] = $product_id;
        $values['list_id'] = $list_id;
        $values['quantity'] = $quantity;
        $list_id = AddEntryToTable('fydp_listitems', $values, true);
        if (is_int($list_id))
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function CheckIfProductInList($product_id, $user_id) {
        $list_id = GetListFromUserID($user_id);
        $SQLConn = SQLConnect();
        $result = mysql_query("SELECT id FROM fydp_listitems WHERE product_id='$product_id' AND list_id='$list_id'");
        SQLDisconnect($SQLConn);
        if (mysql_num_rows($result) != 0)
        {
            return true;
        }
        return false;
    }

    function RemoveProductFromList($product_id, $user_id) {
        $list_id = GetListFromUserID($user_id);
        $SQLConn = SQLConnect();
        $result = mysql_query("DELETE FROM fydp_listitems WHERE product_id='$product_id' AND list_id='$list_id'");
        $error = mysql_error();
        SQLDisconnect($SQLConn);
        if ($error == "")
        {
            return true;
        }
        else {
            return $error;
        }
    }

    function IncrementProductInList($product_id, $user_id) {
        if (!CheckIfProductInList($product_id, $user_id))
        {
            return AddProductToList($product_id, $user_id);
        }
        $list_id = GetListFromUserID($user_id);
        $SQLConn = SQLConnect();
        $result = mysql_query("UPDATE fydp_listitems SET quantity = quantity + 1 WHERE product_id='$product_id' AND list_id='$list_id'");
        $error = mysql_error();
        SQLDisconnect($SQLConn);
        if ($error == "")
        {
            return true;
        }
        else {
            return $error;
        }
    }

    function DecrementProductInList($product_id, $user_id) {
        $list_id = GetListFromUserID($user_id);
        $SQLConn = SQLConnect();
        $result = mysql_query("SELECT id, quantity FROM fydp_listitems WHERE product_id='$product_id' AND list_id='$list_id'");
        $row = mysql_fetch_assoc($result);
        if ($row['quantity'] == 1)
        {
            return RemoveProductFromList($product_id, $user_id);
        }
        $result = mysql_query("UPDATE fydp_listitems SET quantity = quantity - 1 WHERE product_id='$product_id' AND list_id='$list_id'");
        $error = mysql_error();
        SQLDisconnect($SQLConn);
        if ($error == "")
        {
            return true;
        }
        else {
            return $error;
        }
    }

    function GetListFromUserID($user_id) {
        $result = GetRowsFromTable('fydp_lists', 'user_id', $user_id);
        $row = mysql_fetch_assoc($result);
        return $row['id'];
    }

    function cmp($a, $b) {
        if ($a['aisle_position'] == $b['aisle_position'])
        {
            return 0;
        }
        return ($a['aisle_position'] < $b['aisle_position']) ? -1 : 1;
    }

    function rcmp($a, $b) {
        if ($a['aisle_position'] == $b['aisle_position'])
        {
            return 0;
        }
        return ($a['aisle_position'] > $b['aisle_position']) ? -1 : 1;
    }

    function GetShoppingList($user_id) {
        $list_id = GetListFromUserID($user_id);
        $store_id = GetUserStoreFromID($user_id);
        $SQLConn = SQLConnect();
        $columns = "fydp_products.id, fydp_products.title, fydp_products.description, fydp_products.image, fydp_products.category_id, fydp_products.subcategory_id, fydp_products.price, fydp_products.saleprice, fydp_listitems.id as listitem_id, fydp_listitems.product_id, fydp_listitems.list_id, fydp_listitems.quantity, stocks.stock_quantity, fydp_aisles.name as aisle_name, fydp_aisles.number as aisle_number, stocks.stock_aisle_position";
        $join_products = "INNER JOIN fydp_products ON fydp_products.id = fydp_listitems.product_id";
        $join_stocks = "INNER JOIN (SELECT aisle_id as stock_aisle_id, aisle_position as stock_aisle_position, product_id as stock_product_id, store_id as stock_store_id, quantity as stock_quantity FROM fydp_stocks WHERE store_id='$store_id') AS stocks ON stocks.stock_product_id=fydp_listitems.product_id";
        $join_aisles = "INNER JOIN fydp_aisles ON stock_aisle_id = fydp_aisles.id";
        $result = mysql_query("SELECT $columns FROM fydp_listitems $join_products $join_stocks $join_aisles WHERE list_id='$list_id' ORDER BY aisle_number, stock_aisle_position");
        
        $unsorted_list = array();
        while($row = mysql_fetch_assoc($result)){
            $temp['listitem_id'] = $row['listitem_id'];
            $temp['aisle_position'] = $row['aisle_number'].".".$row['stock_aisle_position'];
            $temp['aisle_position_decimal'] = $row['stock_aisle_position'];
            array_push($unsorted_list, $temp);
        }
        $sorted_list = array();
        usort($unsorted_list, "cmp");
        //print_r($unsorted_list);
        //echo "<br/>---<br/>";
        while (count($unsorted_list) > 2)
        {
            array_push($sorted_list, (array_shift($unsorted_list)));
            $last_sorted = end($sorted_list);
            $first_unsorted = $unsorted_list[0];
            $second_unsorted = $unsorted_list[1];


            if (floor($first_unsorted['aisle_position']) != floor($last_sorted['aisle_position'])) //aisle change
            {

                if (($first_unsorted['aisle_position_decimal'] > 4) || 
                     ($first_unsorted['aisle_position_decimal'] < 4 && $last_sorted['aisle_position_decimal'] > 4)
                    )
                {
                    if (floor($first_unsorted['aisle_position']) == floor($second_unsorted['aisle_position'])) //more than 1 item on the next aisle
                    {

                        //echo '<br/>reverse<br/>';
                        //echo '<br/>'.$first_unsorted['aisle_position']."---".$last_sorted['aisle_position'].'<br/>';
                        $buffer = array();
                        array_push($buffer, array_shift($unsorted_list));

                        
                        $first_unsorted = $unsorted_list[0];
                        $last_buffer = end($buffer);

                        //Get all items on the next aisle onto the "buffer" array
                        while(floor($first_unsorted['aisle_position']) == floor($last_buffer['aisle_position'])) {
                            array_push($buffer, array_shift($unsorted_list));
                            if (count($unsorted_list) == 0)
                            {
                                break;
                            }
                            $first_unsorted = $unsorted_list[0];
                            $last_buffer = end($buffer);
                        }
                        //echo '<br/>Buffer: ';
                        //print_r($buffer);
                        //echo '<br/>';


                        //Push the buffer array in reverse order onto the unsorted array
                        while(count($buffer) != 0) {
                            array_unshift($unsorted_list, array_shift($buffer));
                        }

                        //echo '<br/>Post-buffer push: ';
                        //print_r($unsorted_list);
                        //echo '<br/>';
                    }
                    
                }
            }
        }
        array_push($sorted_list, (array_shift($unsorted_list)));
        array_push($sorted_list, (array_shift($unsorted_list)));
        
        //echo '<br/>';
        //print_r($sorted_list);

        $listitem_ids = array();
        
        foreach ($sorted_list as $listitem) {
            array_push($listitem_ids, $listitem['listitem_id']);
        }

        $id = array_shift($listitem_ids);
        $query = "(SELECT $columns FROM fydp_listitems $join_products $join_stocks $join_aisles WHERE fydp_listitems.id='$id' ORDER BY aisle_number, stock_aisle_position)";

        foreach ($listitem_ids as $listitem_id) {
            $query .= " UNION (SELECT $columns FROM fydp_listitems $join_products $join_stocks $join_aisles WHERE fydp_listitems.id='$listitem_id' ORDER BY aisle_number, stock_aisle_position)";
        }
        
        $result = mysql_query($query);
        return $result;
    }

    function GetSubTotal($user_id) {
    	
    	$list_id = GetListFromUserID($user_id);
    	$SQLConn = SQLConnect();
    	$result = mysql_query("SELECT fydp_products.price, fydp_products.saleprice, listitems.quantity FROM (SELECT list_id, product_id, quantity FROM fydp_listitems WHERE list_id='$list_id') AS listitems LEFT JOIN fydp_products ON listitems.product_id = fydp_products.id");
    	$subtotal = 0;
    	while ($row = mysql_fetch_assoc($result)) {
    		if ($row['saleprice'] == 0) {
    			$subtotal += ($row['price']*$row['quantity']);
    		}
    		else
    		{
    			$subtotal += ($row['saleprice']*$row['quantity']);
    		}
    	}
    	return $subtotal;
    	
    }

    /*  
    =================================================
    End Shopping List functions 
     
    */

    
    /*
	=================================================
		Start Stocks functions
	*/
	
	function GetStockFromStoreID($store_id)
	{
		return GetRowsFromTable('fydp_stocks', 'store_id', $store_id);
	}

	function GetStockFromID($id)
	{
		return GetRowFromTableGivenID('fydp_stocks', $id);
	}

    function UpdateStock($values)
	{ 
		return UpdateEntryInTable('fydp_stocks', $values);
	}

    function AddStock($values)
	{
		return AddEntryToTable('fydp_stocks', $values);
	}

    function DeleteStockFromID($id)
	{
		return DeleteRowFromTableGivenID('fydp_stocks', $id);
	}

    /*  
    =================================================
    End Stocks functions 
     
    */
	
	
	/*
	=================================================
		Start Recipe functions
	*/

    function GetRecipes()
	{
		return GetAllFromTable('fydp_recipes');
	}

    function GetRecipeNameFromID($id)
    {
        return GetCellFromTableGivenID('fydp_recipes', 'name', $id);
    }

    function GetRecipeListFromID($recipe_id) {
        return GetRowsFromTable('fydp_recipeitems', 'recipe_id', $recipe_id);
    }

    function AddRecipe($values, $products)
	{
		$recipe_id = AddEntryToTable('fydp_recipes', $values, true);

		if (is_int($recipe_id))
		{
            return AddProductsToRecipeList($products, $recipe_id, true);
		}
        else
        {
            return $recipe_id;
        }
		
	}

    function UpdateRecipe($values, $products)
	{
        print_r($products);
        $response = AddProductsToRecipeList($products, $values['id'], false);
        if (is_bool($response) && $response == true)
        {
            return UpdateEntryInTable('fydp_recipes', $values);
        }
        else
        {
            return $response;
        }
	}

    function AddProductsToRecipeList($products, $recipe_id, $delete_on_fail=false) {
        $SQLConn = SQLConnect();
        mysql_query("DELETE FROM fydp_recipeitems WHERE recipe_id='$recipe_id'");
        SQLDisconnect($SQLConn);
        $values = "";
        $values['recipe_id'] = $recipe_id;
        foreach($products as $product) {
            $values['product_id'] = $product;
            $recipeitem_id = AddEntryToTable('fydp_recipeitems', $values, true);
            if (!is_int($recipeitem_id))
            {
                if ($delete_on_fail)
                {
                    DeleteRecipeFromID($recipe_id);
                }
                return $recipeitem_id;
            }
            
        }
        return true;
    }
	
	function GetRecipeFromID($id)
	{
		return GetRowFromTableGivenID('fydp_recipes', $id);
	}

    function DeleteRecipeFromID($id)
    {
        $imageFile = GetRecipeImageFromID($id);
        if ($imageFile != "images/addrecipe.png")
        {
            unlink($imageFile);
        }
		return DeleteRowFromTableGivenID('fydp_recipes', $id);
	}

    function GetRecipeImageFromID($id)
    {
        return GetCellFromTableGivenID('fydp_recipes', 'image', $id);
    }

    function GetFeaturedRecipes($amount='1') {

        $SQLConn = SQLConnect();
        
        $result = mysql_query("SELECT * FROM fydp_recipes ORDER BY RAND() LIMIT $amount");
        
        if (mysql_error() != "" || mysql_num_rows($result) == 0)
        {
            return false;
        }
        return $result;
    }

    function GetRecipeCategories() {
        $SQLConn = SQLConnect();
        
        $result = mysql_query("SELECT DISTINCT category, (SELECT COUNT(*) FROM fydp_recipes f_r_a WHERE f_r_a.category = f_r.category) AS count FROM fydp_recipes f_r ORDER BY category ASC");

        return $result;
    }

    function GetNumRecipeSearchPages($search_string, $category_search = false) {
        $search_string = mysql_escape_string($search_string);
        $SQLConn = SQLConnect();
        if (!$category_search)
        {
            $result = SearchRecipe($search_string);
        }
        else
        {
            $result = SearchRecipeCategory($search_string);
        }
        return ceil(mysql_num_rows($result)/5);
    }

    function GetProductsInRecipe($recipe_id, $user_id='0'){
        $SQLConn = SQLConnect();
        if ($user_id != '0') {
            $list_id = GetListFromUserID($user_id);
            $store_id = GetUserStoreFromID($user_id);
            $SQLConn = SQLConnect();
            $columns = "fydp_products.id, fydp_products.title, fydp_products.description, fydp_products.image, fydp_products.category_id, fydp_products.subcategory_id, fydp_products.price, fydp_products.saleprice, listitems.id as listitem_id, listitems.product_id, listitems.list_id, listitems.quantity, stocks.stock_quantity, fydp_aisles.name as aisle_name, fydp_aisles.number as aisle_number, stocks.stock_aisle_position, fydp_recipeitems.recipe_id, fydp_recipeitems.product_id";
            $join_products = "INNER JOIN fydp_products ON fydp_products.id = fydp_recipeitems.product_id";
            $join_list = "LEFT JOIN (SELECT id, product_id, list_id, quantity FROM fydp_listitems WHERE list_id='$list_id') AS listitems ON listitems.product_id = fydp_products.id ";
            $join_stocks = "INNER JOIN (SELECT aisle_id as stock_aisle_id, aisle_position as stock_aisle_position, product_id as stock_product_id, store_id as stock_store_id, quantity as stock_quantity FROM fydp_stocks WHERE store_id='$store_id') AS stocks ON stocks.stock_product_id=fydp_products.id";
            $join_aisles = "INNER JOIN fydp_aisles ON stock_aisle_id = fydp_aisles.id";
                
            $query = "SELECT $columns FROM fydp_recipeitems $join_products $join_list $join_stocks $join_aisles WHERE fydp_recipeitems.recipe_id='$recipe_id'";
            
            $result = mysql_query($query);
            
            return $result;
        }
        else
        {
            $columns = "fydp_products.id, fydp_products.title, fydp_products.description, fydp_products.image, fydp_products.category_id, fydp_products.subcategory_id, fydp_products.price, fydp_products.saleprice, fydp_recipeitems.recipe_id, fydp_recipeitems.product_id";
            $result = mysql_query("SELECT $columns FROM fydp_recipeitems INNER JOIN fydp_products ON fydp_products.id = fydp_recipeitems.product_id WHERE fydp_recipeitems.recipe_id='$recipe_id'");
            return $result;
        }
        
    }

    function SearchRecipeCategory($search_string, $page=0) {
        
        $search_string = trim(mysql_escape_string(urldecode($search_string)));

        $search_string = str_replace("%", "\%", $search_string);
                
        $SQLConn = SQLConnect();

        //Calculate offset based on $page. 5 items per page.
        $offset = ($page-1) * 5;
        $row_count = 5;

        
        //First priority query = covers the case where "chicken beef pork" is present and are not being separated by other words
        $query = "SELECT * FROM fydp_recipes WHERE category = '$search_string'";

        //Slice the results if for a specific page - e.g. If for page 2, show only results 6 - 10.
        //If $page == 0, then all the results are returned.
        if ($page != 0)
        {
            $query .= " LIMIT $offset, $row_count";
        }
        
        $result = mysql_query($query);
        return $result;
    }

    function SearchRecipe($search_string, $page=0) {
        $search_string = trim(mysql_escape_string($search_string));

        $search_string = str_replace("%", "\%", $search_string);

        $SQLConn = SQLConnect();

        //Separate words and put into array
        $keywords = explode(' ', $search_string);
        
        //Create wildcard for multiple words. e.g. "chicken beef pork" -> "chicken % beef % pork"
        $search_string_wildcard = str_replace(" ", " % ", $search_string);

        //Calculate offset based on $page. 5 items per page.
        $offset = ($page-1) * 5;
        $row_count = 5;

        //First priority query = covers the case where "chicken beef pork" is present and are not being separated by other words
        $query = "(SELECT * FROM fydp_recipes WHERE name = '$search_string' || name LIKE '% $search_string %' || name LIKE '% $search_string' || name LIKE '$search_string %')";
            
        //Second priority query = covers the case where "chicken" and "beef" and "pork" are present but they could be separated
        //by other words
        if ($search_string_wildcard != $search_string) {
            $query .= " UNION (SELECT * FROM fydp_recipes WHERE name LIKE '% $search_string_wildcard%')";
        }

        //Third priority query = covers the case where either "chicken" or "beef" or "pork" is present but not all 3
            
        foreach ($keywords as $keyword) {
            $query .= " UNION (SELECT * FROM fydp_recipes WHERE name LIKE '% $keyword%' || name LIKE '% $keyword' || name LIKE '$keyword%')";
        }
        
        //Slice the results if for a specific page - e.g. If for page 2, show only results 6 - 10.
        //If $page == 0, then all the results are returned.
        if ($page != 0)
        {
            $query .= " LIMIT $offset, $row_count";
        }
        
        $result = mysql_query($query);
        return $result;
    }

    /*
		End Recipe functions
	=================================================
	*/


	/*
	=================================================
		Start Product functions
	*/

	function GetProducts()
	{
		return GetAllFromTable('fydp_products');
	}

    function GetProductsFromCategoryID($category_id) {
        return GetRowsFromTable('fydp_products', 'category_id', $category_id);
    }

	function AddProduct($values)
	{
        if ($values['saleprice'] == "")
        {
            $values['saleprice'] = 0;
        }
		if (($response = AddEntryToTable('fydp_products', $values)) == '1')
		{
			return true;
		}
		return $response;
		
	}
	
	function GetProductFromID($id)
	{
		return GetRowFromTableGivenID('fydp_products', $id);
	}

    function GetProductTitleFromID($id)
    {
        return GetCellFromTableGivenID('fydp_products', 'title', $id);
    }

    function GetProductImageFromID($id)
    {
        return GetCellFromTableGivenID('fydp_products', 'image', $id);
    }

	function DeleteProductFromID($id)
    {
        $imageFile = GetProductImageFromID($id);
        if ($imageFile != "images/addproduct.png")
        {
            unlink($imageFile);
        }
		return DeleteRowFromTableGivenID('fydp_products', $id);
	}

	function UpdateProduct($values)
	{
		return UpdateEntryInTable('fydp_products', $values);
	}

    function GetFeaturedProducts($amount='1', $logged_in=false, $user_id=0) {

        $SQLConn = SQLConnect();
        $result;
        
        if ($logged_in==false)
        {
            $result = mysql_query("SELECT * FROM fydp_products WHERE saleprice != 0 ORDER BY RAND() LIMIT $amount");
        }
        else
        {
            $list_id = GetListFromUserID($user_id);
            $store_id = GetUserStoreFromID($user_id);
            $extra_query = "LEFT JOIN (SELECT product_id, list_id, quantity FROM fydp_listitems WHERE list_id='$list_id') AS listitems ON listitems.product_id = fydp_products.id ".
                           "LEFT JOIN (SELECT product_id as stock_product_id, aisle_id as stock_aisle_id, quantity as stock_quantity FROM fydp_stocks WHERE store_id='$store_id') AS stocks ON stocks.stock_product_id = fydp_products.id ".
                           "LEFT JOIN (SELECT id AS aisle_id, name as aisle_name, number as aisle_number FROM fydp_aisles) AS aisles ON stock_aisle_id=aisles.aisle_id";

            
            $SQLConn = SQLConnect();
            $result = mysql_query("SELECT * FROM fydp_products $extra_query WHERE saleprice != 0 ORDER BY RAND() LIMIT $amount");
        }
        if (mysql_error() != "" || mysql_num_rows($result) == 0)
        {
            return false;
        }
        return $result;
    }


    function GetNumSearchPages($search_string, $category_search = false) {
        $search_string = mysql_escape_string($search_string);
        $SQLConn = SQLConnect();
        if (!$category_search)
        {
            $result = SearchProduct($search_string);
        }
        else
        {
            $result = SearchCategory($search_string);
        }
        return ceil(mysql_num_rows($result)/5);
    }

    function SearchCategory($search_string, $page=0, $price_direction="", $logged_in = false, $user_id = 0) {
        
        $search_string = trim(mysql_escape_string(urldecode($search_string)));

        $search_string = str_replace("%", "\%", $search_string);
        $list_id = 0;
        $store_id = 0;
        if ($logged_in)
        {
            $list_id = GetListFromUserID($user_id);
        }
        if ($user_id != 0)
        {
            $store_id = GetUserStoreFromID($user_id);
        }
        
        $SQLConn = SQLConnect();

        //Calculate offset based on $page. 5 items per page.
        $offset = ($page-1) * 5;
        $row_count = 5;

        if ($logged_in)
        {
            
            $extra_query = "LEFT JOIN (SELECT product_id, list_id, quantity FROM fydp_listitems WHERE list_id='$list_id') AS listitems ON listitems.product_id = fydp_products.id ".
                           "LEFT JOIN (SELECT product_id as stock_product_id, aisle_id as stock_aisle_id, quantity as stock_quantity FROM fydp_stocks WHERE store_id='$store_id') AS stocks ON stocks.stock_product_id = fydp_products.id ".
                           "LEFT JOIN (SELECT id AS aisle_id, name as aisle_name, number as aisle_number FROM fydp_aisles) AS aisles ON stock_aisle_id=aisles.aisle_id";
            //First priority query = covers the case where "chicken beef pork" is present and are not being separated by other words
            $query = "SELECT * FROM fydp_products INNER JOIN (SELECT id as prod_id, name FROM fydp_categories) AS categories ON fydp_products.category_id = categories.prod_id $extra_query WHERE name = '$search_string'";
        }
        else {
            //First priority query = covers the case where "chicken beef pork" is present and are not being separated by other words
            $query = "SELECT * FROM fydp_products INNER JOIN (SELECT id as prod_id, name FROM fydp_categories) AS categories ON fydp_products.category_id = categories.prod_id WHERE name = '$search_string'";
        }
        

        //Sort by price ascending
        if ($price_direction == "asc")
        {
            $query .= " ORDER BY price ASC";
        }
        //Or sort by price descending
        elseif ($price_direction == "desc") {
            $query .= " ORDER BY price DESC";
        }

        //Slice the results if for a specific page - e.g. If for page 2, show only results 6 - 10.
        //If $page == 0, then all the results are returned.
        if ($page != 0)
        {
            $query .= " LIMIT $offset, $row_count";
        }
        
        $result = mysql_query($query);
        return $result;
    }

    function SearchProduct($search_string, $page=0, $price_direction="", $logged_in = false, $user_id = 0) {
        $search_string = trim(mysql_escape_string($search_string));

        $search_string = str_replace("%", "\%", $search_string);
        $list_id = 0;
        $store_id = 0;
        if ($logged_in)
        {
            $list_id = GetListFromUserID($user_id);
        }
        
        if ($user_id != 0)
        {
            $store_id = GetUserStoreFromID($user_id);
        }

        $SQLConn = SQLConnect();

        //Separate words and put into array
        $keywords = explode(' ', $search_string);
        
        //Create wildcard for multiple words. e.g. "chicken beef pork" -> "chicken % beef % pork"
        $search_string_wildcard = str_replace(" ", " % ", $search_string);

        //Calculate offset based on $page. 5 items per page.
        $offset = ($page-1) * 5;
        $row_count = 5;

        if ($logged_in)
        {
            
            $extra_query = "LEFT JOIN (SELECT product_id, list_id, quantity FROM fydp_listitems WHERE list_id='$list_id') AS listitems ON listitems.product_id = fydp_products.id ".
                           "LEFT JOIN (SELECT product_id as stock_product_id, aisle_id as stock_aisle_id, quantity as stock_quantity FROM fydp_stocks WHERE store_id='$store_id') AS stocks ON stocks.stock_product_id = fydp_products.id ".
                           "LEFT JOIN (SELECT id AS aisle_id, name as aisle_name, number as aisle_number FROM fydp_aisles) AS aisles ON stock_aisle_id=aisles.aisle_id";
            //First priority query = covers the case where "chicken beef pork" is present and are not being separated by other words
            $query = "(SELECT * FROM fydp_products $extra_query WHERE title = '$search_string' || title LIKE '% $search_string %' || title LIKE '% $search_string' || title LIKE '$search_string %')";
            
            //Second priority query = covers the case where "chicken" and "beef" and "pork" are present but they could be separated
            //by other words
            if ($search_string_wildcard != $search_string) {
                $query .= " UNION (SELECT * FROM fydp_products $extra_query WHERE title LIKE '% $search_string_wildcard%')";
            }
    
            //Third priority query = covers the case where either "chicken" or "beef" or "pork" is present but not all 3
            
            foreach ($keywords as $keyword) {
                $query .= " UNION (SELECT * FROM fydp_products $extra_query WHERE title LIKE '% $keyword%' || title LIKE '% $keyword' || title LIKE '$keyword%')";
            }
        }
        else {
            //First priority query = covers the case where "chicken beef pork" is present and are not being separated by other words
            $query = "(SELECT * FROM fydp_products WHERE title = '$search_string' || title LIKE '% $search_string %' || title LIKE '% $search_string' || title LIKE '$search_string %')";
            
            //Second priority query = covers the case where "chicken" and "beef" and "pork" are present but they could be separated
            //by other words
            if ($search_string_wildcard != $search_string) {
                $query .= " UNION (SELECT * FROM fydp_products WHERE title LIKE '% $search_string_wildcard%')";
            }
    
            //Third priority query = covers the case where either "chicken" or "beef" or "pork" is present but not all 3
            
            foreach ($keywords as $keyword) {
                $query .= " UNION (SELECT * FROM fydp_products WHERE title LIKE '% $keyword%' || title LIKE '% $keyword' || title LIKE '$keyword%')";
            }
        }
        

        //Sort by price ascending
        if ($price_direction == "asc")
        {
            $query .= " ORDER BY price ASC";
        }
        //Or sort by price descending
        elseif ($price_direction == "desc") {
            $query .= " ORDER BY price DESC";
        }

        //Slice the results if for a specific page - e.g. If for page 2, show only results 6 - 10.
        //If $page == 0, then all the results are returned.
        if ($page != 0)
        {
            $query .= " LIMIT $offset, $row_count";
        }
        
        $result = mysql_query($query);
        echo mysql_error();
        return $result;
    }

	/*
	=================================================
		End Critique functions
	*/
	
	/*
		Start Core functions
	=================================================
	*/
	
	function Authenticated($email, $password)
	{
        $email = mysql_escape_string($email);
		$SQLConn = SQLConnect();
		
		$table = 'fydp_users';

		$result = mysql_query("SELECT * FROM $table WHERE email='$email'");
		
		if (mysql_num_rows($result) == 0) return false;

		$row = mysql_fetch_assoc($result);
		
		if ($row['password'] == $password) 
		{
			if ($row['inactive'] == 1)
			{
				mysql_query("UPDATE $table SET inactive='0' WHERE email='$email'");
				if (mysql_error())
				{
					return mysql_error();
				}
			}
			return true;
		}
		
		return false;
	}

	function ChangePassword($username, $oldpassword, $newpassword, $renewpassword)
	{
		if (Authenticated($username, $oldpassword))
		{
			if ($newpassword == $renewpassword)
			{
				$password = md5($newpassword);
				$SQLConn = SQLConnect();
				$result = mysql_query("UPDATE fydp_users SET password='$password' WHERE email='$username'");
				if ($response = mysql_error())
				{
					return $response;
				}
				SQLDisconnect($SQLConn);
				
				return "Password has been successfully changed.";
			}
			else
			{
				return "The two new passwords do not match.";
			}
		}
		else
		{
			return "The old password is incorrect.";
		}
		
	}

	function MakeRandomPassword()
	{
		srand ((double) microtime() * 10000000);
		$letters = array("A", "B", "C", "D", "E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
		$rand_index = array_rand($letters, 4);
		$password = rand(1,9).$letters[$rand_index[0]].rand(1,9).$letters[$rand_index[1]].rand(1,9).$letters[$rand_index[2]].rand(1,9).$letters[$rand_index[3]];
		return $password;	
	}

	function IsAdmin($email)
	{
		global $sMasterAdminLevel;
        $email = mysql_escape_string($email);
		$SQLConn = SQLConnect();
		$result = mysql_query("SELECT * FROM fydp_users WHERE email='$email' AND admin='$sMasterAdminLevel'");
		SQLDisconnect($SQLConn);
		return (mysql_num_rows($result) == 1);
	}

	function GetRowFromTableGivenID($table, $id)
	{
		$SQLConn = SQLConnect();
		$result = mysql_query("SELECT * FROM $table WHERE id='".mysql_escape_string($id)."'");
		SQLDisconnect($SQLConn);
		return $result;
	}

	function GetAllFromTable($table)
	{
		$SQLConn = SQLConnect();
		$result = mysql_query("SELECT * FROM $table");
		SQLDisconnect($SQLConn);
		return $result;
	}

    function GetAllFromTableSort($table, $sort_column, $direction="ASC")
    {
        $SQLConn = SQLConnect();
		$result = mysql_query("SELECT * FROM $table ORDER BY $sort_column $direction");
		SQLDisconnect($SQLConn);
		return $result;
    }

	function GetCellFromTableGivenID($table, $column, $id)
	{
		$result = GetRowFromTableGivenID($table, $id);
		$row = mysql_fetch_assoc($result);
		return $row[$column];
	}	

	function GetHighestIDFromTable($table)
	{
		$SQLConn = SQLConnect();
		$result = mysql_query("SELECT id FROM $table ORDER BY id DESC");
		SQLDisconnect($SQLConn);
		$row = mysql_fetch_assoc($result);
		return $row['id'];
	}

	function GetRowsFromTable($table, $col_name, $col_value)
	{
		$SQLConn = SQLConnect();
		$result = mysql_query("SELECT * FROM $table WHERE $col_name='$col_value'");
		SQLDisconnect($SQLConn);
		return $result;
	}

	function GetColumnFromTable($table, $column)
	{
	}

	function DeleteRowFromTableGivenID($table, $id)
	{
		$SQLConn = SQLConnect();
		mysql_query("DELETE FROM $table WHERE id='$id'");

		if (mysql_error() == "")
		{
			$result = mysql_query("SELECT * FROM $table WHERE id='$id'");
			if (mysql_num_rows($result) != 0)
			{
				return "Delete failed: ID: $id still exists in table: $table";
			}
		}
		else
		{
			return mysql_error();
		}
		
		SQLDisconnect($SQLConn);
		return true;
	}

    function UpdateCellGivenID($table, $column, $id, $value)
    {
        if (!isset($id) || $id == "")
        {
            return "No ID was provided to query the database.";
        }
        if ($table == "")
		{
			return "Table name not specified for update.";
		}
        if ($column == "")
		{
			return "Column name not specified for update.";
		}
        $SQLConn = SQLConnect();
        mysql_query("UPDATE $table SET $column='".mysql_escape_string($value)."' WHERE id='$id'");
        SQLDisconnect($SQLConn);
        $value_check = GetCellFromTableGivenID($table, $column, $id);
        
        if ($value_check == $value)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

	function UpdateEntryInTable($table, $values)
	{
		if ($values['id'] == "")
		{
			return "No ID was provided to query the database.";
		}
		if ($table == "")
		{
			return "Table name not specified for update.";
		}

		$id = $values['id'];	
		unset ($values['id']);
		$SQLConn = SQLConnect();
		foreach ($values as $key => $value)
		{
			mysql_query("UPDATE $table SET ".$key."='".mysql_escape_string($value)."' WHERE id='$id'");
			if (mysql_error() != "")
			{
				return mysql_error();
			}
		} 
		
		$result = mysql_query("SELECT * FROM $table WHERE id='$id'");
		$row = mysql_fetch_assoc($result);
		SQLDisconnect($SQLConn);
		
		foreach ($values as $key => $value)
		{
			if ($row[$key] != $value)
			{
                if (floor($row[$key]) != floor($value))
                {
                    return "Update failed! Updated '$key' = '$value' but got '$key' = '$row[$key]'";
                }
			}
		} 
		return true;
	}

	function AddEntryToTable($table, $values, $bool_return_id=false)
	{
		if ($table == "")
		{
			return "Table name not specified for add";
		}
		$SQLConn = SQLConnect();
	
		$columnList = "";
		$valueList = "";
		foreach ($values as $key => $value)
		{
			if ($columnList == "")
			{
				$columnList = mysql_escape_string($key);
			}
			else
			{
				$columnList = $columnList.", ".mysql_escape_string($key);
			}
			if ($valueList == "")
			{
				$valueList = "'".mysql_escape_string($value)."'";
			}
			else
			{
				$valueList = $valueList.", "."'".mysql_escape_string($value)."'";
			}
		}	
		mysql_query("INSERT INTO $table(". $columnList. ") values(".$valueList.")");
		if (mysql_error() != "")
		{
			return mysql_error();
		}
		$id = mysql_insert_id();	
		$result = mysql_query("SELECT * FROM $table WHERE id='$id'");
		$row = mysql_fetch_assoc($result);
		SQLDisconnect($SQLConn);
		foreach ($values as $key => $value)
		{
			if ($value != $row[$key])
			{
                if (floor($value) != floor($row[$key]))
                {
                    mysql_query("DELETE FROM $table WHERE id='$id'");
                    return "Add failed! Inserted '$key' = '$value' but got '$key' = '$row[$key]'";
                }
			}
		}
		if ($bool_return_id) 
		{
			return $id;
		}
		else
		{
			return true;
		}
	}

	function sqlrow2xml($result)
	{
		$row = mysql_fetch_assoc($result);
		$xmlData = "";	
		foreach ($row as $key => $value)
		{
			$xmlData = $xmlData . "<div class=\"x$key\">$value</div>";
		}
		return $xmlData;
	}

    function Currencize($number) {
        if ($number == 0)
        {
            return;
        }
        return '$'.$number;
    }

	/*
	=================================================
		End Core functions
	*/
?>
