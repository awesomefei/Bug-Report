<?php

function login_user($username, $password){
    global $connection;
    
    $username = trim($username);
    $password = trim($password);
//avoid hack
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    if(!$select_user_query){
        die("QUERY FAILED". mysqli_error($connection));
    }
    while($row = mysqli_fetch_array($select_user_query)){
          $db_user_firstname = $row['user_firstname'];
         $db_user_lastname = $row['user_lastname'];
       
         $db_user_id = $row['user_id'];
         $db_username = $row['username'];  
         $db_user_password = $row['user_password'];
         $db_user_email = $row['user_email'];
         $db_user_image = $row['user_image'];
         $db_user_role = $row['user_role'];
         $db_user_level = $row['user_levle'];
         $db_user_department = $row['user_department'];

    }
    
    if(password_verify($password, $db_user_password)){
        $_SESSION['username']= $db_username;
        $_SESSION['user_id']= $db_user_id;
        $_SESSION['firstname']= $db_user_firstname;
        $_SESSION['lastname']= $db_user_lastname;
        $_SESSION['email']= $db_user_email;
        $_SESSION['user_role']= $db_user_role;
        redirect("/BugReport/admin/assign_to_me.php");
    }else {
        redirect("/BugReport/index.php");
    } 
 
}

function isAdmin($username=''){
    global $connection;
    $query = "SELECT role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    $row = mysqli_fetch_array($result);
    if($row['role'] == 'admin'){
        return true;
    }else{
        return false;
    }
}


function is_username_duplicate($username){
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }
}

function is_email_duplicate($email){
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    if(mysqli_num_rows($result) > 0){
        return true;
    }else{
        return false;
    }
}

function register_user($username, $email, $password, $department, $level, $firstname, $lastname, $image){
    global $connection;
       
    $username = mysqli_real_escape_string($connection,$username);
    $email = mysqli_real_escape_string($connection,$email);
    $password = mysqli_real_escape_string($connection,$password);
    
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' =>12) );

    $query = "INSERT INTO users (username, user_email, user_password, user_department, user_level, user_firstname, user_lastname, user_image) ";
    $query .= "VALUE('{$username}', '{$email}', '{$password}', '{$department}' , '{$level}', '{$firstname}','{$lastname}','{$image}')";
    $register_user_query = mysqli_query($connection, $query);

    confirmQuery($register_user_query);
    
}

function redirect($location){
    return header('Location:' . $location);
}

//for secuity of deploying to internet
function escape($string){
    global $connection;
    mysqli_real_escape_string($connection, trim($string));
}


function confirmQuery($result){
    global $connection;
    if(!$result){
        die("QUERY FAILED ." . mysqli_error($connection));
    }
}

function insert_categories(){
    global $connection;
    if(isset($_POST['submit'])){
    $cat_title = $_POST['cat_title'];
    if($cat_title == "" || empty($cat_title)) {
        echo "this field should not be empty";
    }else{
        $query = "INSERT INTO category(cat_title)";
        $query .= "VALUE('{$cat_title}')";
        $create_category_quert = mysqli_query($connection, $query);
        if(!$create_category_quert){
            die('QUERY FAILED' . mysqli_error($connection));
        }
    }
}  
}

function findAllCategories(){
    global $connection;
    $query = 'SELECT * FROM category ';
    $select_cat = mysqli_query($connection,$query);                                    
    while($row = mysqli_fetch_assoc($select_cat)){
        $cat_title = $row['cat_title'];
        $cat_id = $row['cat_id'];
        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Update</a></td>";

        echo "<tr>";
    }
}

function deleteCategory(){
    global $connection;    
    if(isset($_GET['delete'])){
        $the_cat_id = $_GET['delete'];
        $query = "DELETE FROM category WHERE cat_id = {$the_cat_id}";
        $delete_query = mysqli_query($connection, $query);
        header('Location: categories.php');
    }  
}

?>