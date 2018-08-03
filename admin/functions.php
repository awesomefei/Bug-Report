<?php

function get_bug_by_id($the_bug_id) {
    global $connection;
    $query = "SELECT * FROM bug WHERE bug_id = $the_bug_id LIMIT 1 ";
    $select_bug_query = mysqli_query($connection, $query);
    confirmQuery($select_bug_query);
    return $select_bug_query;
}

function get_all_departments() {
    global $connection;
    $look_up_query = "SELECT * FROM department";
    $department_query = mysqli_query($connection, $look_up_query);
    confirmQuery($department_query);
    return $department_query;
}

function get_enum($table_name, $colum_name) {
    global $connection;
    $query = "SELECT COLUMN_TYPE FROM information_schema.COLUMNS WHERE 
    TABLE_NAME = '$table_name' AND COLUMN_NAME = '$colum_name'";
    $bug_type_query = mysqli_query($connection,$query);
    confirmQuery($bug_type_query);
    $row = mysqli_fetch_assoc($bug_type_query);
    $enumList = explode(",", str_replace("'", "", 
                substr($row['COLUMN_TYPE'], 5, 
                       (strlen($row['COLUMN_TYPE'])-6))));
    
    foreach($enumList as $value)
        echo "<option value='{$value}'>$value</option>";
}

function get_each_page_display_num($dispay_per_page, $page_num){
    return ($page_num * $dispay_per_page) - $dispay_per_page;
}

function display_page($total_page_count,$page_num){
    for($current_page = 1; $current_page <= $total_page_count ; 
    $current_page++){
        if($current_page == $page_num){
            echo "<li class='page-item active'><a class='page-link' 
            href='assign_to_me.php?page={$current_page}'>
            {$current_page}</a></li>";
        }else{
            echo "<li><a href='assign_to_me.php?page={$current_page}'>
            {$current_page}</a></li>";
        }
    }
}

function get_total_page_count($target_user_id){
    global $connection;
    $dispay_per_page = 10;
    $bug_total_count = "SELECT * FROM bug WHERE bug_assignee_id = 
    $target_user_id ";
    $find_count = mysqli_query($connection,$bug_total_count);
    $count = mysqli_num_rows($find_count);
    return ceil($count/$dispay_per_page);
}


function iterate_enum_in_table($table_name, $column_name){
    global $connection; 
    $query = "SELECT COLUMN_TYPE FROM information_schema.COLUMNS WHERE 
    TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name' ";
    $bug_type_query = mysqli_query($connection,$query);
    confirmQuery($bug_type_query);
    $row = mysqli_fetch_assoc($bug_type_query);
    return explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 
            5, (strlen($row['COLUMN_TYPE'])-6))));
}

function increase_comment_query($bug_comment_count, $bug_id){
    global $connection;
    $query = $bug_comment_count_query1 = "UPDATE bug SET comment_count = 
    $bug_comment_count+1 WHERE bug_id = $bug_id LIMIT 1 ";
    $increase_bug_comment_query = mysqli_query($connection, $query);
    confirmQuery($increase_bug_comment_query);     
}

function create_tag($name){
    global $connection;
    $query = "INSERT INTO tags(tag_name) VALUES ('{$name}') ";
    $create_tag_query = mysqli_query($connection, $query);
    confirmQuery($create_tag_query);
}

function get_tag_by_name($name){
    global $connection;
    $qeury = "SELECT * FROM tags WHERE tag_name = '$name' ";
    $tag_query = mysqli_query($connection, $qeury);
    confirmQuery($tag_query);
    return $tag_query;
}

function get_tag_count($query){
    return mysqli_num_rows($query);
}

function create_comment($comment_content, $bug_id, $user_id){
    global $connection;
    if(!empty($comment_content)){
        
        $query = "INSERT INTO comment (bug_id, user_id, comment_content, 
        comment_date) ";
    
        $query .= "VALUES ($bug_id , $user_id, '{$comment_content}', 
        now())";
        $create_comment_query = mysqli_query($connection, $query);
        confirmQuery($create_comment_query);
    }
}

function get_all_users(){
    global $connection;
    $query = "SELECT * FROM users ";
    $user_query = mysqli_query($connection,$query);
    confirmQuery($user_query);
    return $user_query;
}

function search_user_by_id($user_id){
    global $connection;
    $user_query = "SELECT * FROM users WHERE user_id = $user_id LIMIT 1 ";
    $user_id_query = mysqli_query($connection, $user_query);
    confirmQuery($user_id_query);
    return $user_id_query;
}

function get_user_id_by_email($email){
    global $connection;
    $target_user_query = "SELECT user_id FROM users WHERE user_email = 
    '{$email}' LIMIT 1 ";
    $user_id = mysqli_query($connection,$target_user_query);
    confirmQuery($user_id); 
    $row = mysqli_fetch_array($user_id);
    $target_user_id = $row['user_id'];
    return $target_user_id;
}

function get_primary_id(){
    global $connection;
    $qeury_id = "SELECT LAST_INSERT_ID()";
    $qeury_id_query = mysqli_query($connection, $qeury_id);  
    $row = mysqli_fetch_array($qeury_id_query);
    return $row[0];
}

function get_tag_id_by_tag_name($tag_name){
    global $connection;
    $id_query = "SELECT tag_id FROM tags WHERE tag_name = '{$tag_name}' 
    LIMIT 1 ";
    $tag_id_query = mysqli_query($connection, $id_query);  
    confirmQuery($tag_id_query);
    $tag_id = mysqli_fetch_array($tag_id_query); 
    return $tag_id[0];
}

function create_bug_tag($bug_id, $tag_id){
    global $connection;
    $bug_tag_query = "INSERT INTO bug_tag(bug_id, tag_id) 
    VALUES('{$bug_id}', '{$tag_id}')";
    $create_bug_tag_query = mysqli_query($connection, $bug_tag_query);  
    confirmQuery('@@@@@@@@' . $create_bug_tag_query);
}

function appendSortBy($query, $source){
    $str = "ORDER BY ";
    switch($source){
        case 'sortByPriority';
            return $query .=$str . "priority ";
            break;
        case 'sortById';
            return $query .=$str . "bug_id ";
            break;
        case 'sortByLastModifiedTime';
            return $query .=$str . "lastupdate ";
            break;
        default:
            return $query .=$str . "bug_id DESC ";
        break;
    } 
}

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

function register_user($username, $email, $password, $component, $level, 
                       $firstname, $lastname, $image){
    global $connection;
       
    $username = mysqli_real_escape_string($connection,$username);
    $email = mysqli_real_escape_string($connection,$email);
    $password = mysqli_real_escape_string($connection,$password);
    
    $password = password_hash($password, PASSWORD_BCRYPT, 
                              array('cost' =>12) );
    //parse $component to $component_id
    $com_query = "SELECT component_id FROM component WHERE 
    component_title = '$component' LIMIT 1 ";
    $com_id_query = mysqli_query($connection, $com_query);
    confirmQuery($com_id_query);
    while($row = mysqli_fetch_assoc($com_id_query)){
        $component_id = $row[component_id];

        $query = "INSERT INTO users (username, user_email, user_password, 
        component_id, user_level, user_firstname, user_lastname, 
        user_image) ";
        $query .= "VALUE('{$username}', '{$email}', '{$password}', 
        {$component_id} , '{$level}', '{$firstname}','{$lastname}',
        '{$image}')";
        $register_user_query = mysqli_query($connection, $query);

        confirmQuery($register_user_query);
        }
    
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
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a>
        </td>";
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