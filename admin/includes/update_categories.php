
<?php

    if(isset($_GET['edit'])){
        
         //Making sure only admin users can delete users
    if(isset($_SESSION['user_role'])){
        
        if($_SESSION['user_role'] == 'admin'){

    $cat_id = escape($_GET['edit']);

    $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
    $select_categories_id = mysqli_query( $connection, $query);

    while($row = mysqli_fetch_assoc($select_categories_id)){
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

?>

    <input value="<?php if(isset($cat_title)){echo $cat_title;}   ?>" type="text" class="form-control" name="cat_title">

<?php }} } } ?>
                
                
<?php

//////////UPDATE QUERY

    if(isset($_POST['update_category'])) {
        
    //Making sure only admin users can edit categories
    if(isset($_SESSION['user_role'])){
        
        if($_SESSION['user_role'] == 'admin'){

        $the_cat_title = escape($_POST['cat_title']); // This needs to be cat_title,becase that's the name of the text field in the dynamic input field created above.

        $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");
        mysqli_stmt_bind_param($stmt, "si", $the_cat_title, $cat_id);
        mysqli_stmt_execute($stmt);

        confirmQuery($stmt);
            
        mysqli_stmt_close($stmt);    
            
        redirect("categories.php");
            
        }
    }

}

?>
                