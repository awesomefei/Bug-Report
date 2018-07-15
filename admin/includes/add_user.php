<?php

if(isset($_POST['create_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
//
//    $user_image        = $_FILES['image']['name'];
//    $user_image_temp   = $_FILES['image']['tmp_name'];

    $username           = $_POST['username'];
    $user_email         = $_POST['user_email'];
    $user_password      = $_POST['user_password'];

//    move_uploaded_file($post_image_temp, "../image/$post_image" );

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10) );
    $query = "INSERT INTO users(user_firstname, user_lastname, role,username,user_email,user_password) ";

    $query .= "VALUES('{$user_firstname}','{$user_lastname}','{$user_role}','{$username}','{$user_email}','{$user_password}') "; 

    $create_user_query = mysqli_query($connection, $query);  

    confirmQuery($create_user_query);
    echo "User Created: " . " " . "<a href='users.php'> View Users</a> ";
    
//    $the_user_id = mysqli_insert_id($connection);
//    
//    echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='posts.php'>Edit More Posts</a></p>";
       


   }    
?> 
<form action="" method="post" enctype="multipart/form-data">    

<div class="form-group">
     <label for="title">Firstname</label>
      <input type="text" class="form-control" name="user_firstname">
</div>

<div class="form-group">
     <label for="title">Lastname</label>
      <input type="text" class="form-control" name="user_lastname">
</div>


<div class="form-group">
     <select name="user_role" >
     <option value="subscriber">Select Options</option>
     <option value="admin">Admin</option>
     <option value="subscriber">Subscriber</option>

<?php
//    $query = "SELECT * FROM users";
//    $select_user = mysqli_query($connection,$query);
//    confirmQuery($select_user);
//    while($row = mysqli_fetch_assoc($select_user)){
//        $user_id = $row['user_id'];
//        $user_role = $row['role']; 
//        echo "<option value='{$user_id}'>{$user_role}</option>";
//    }
?>
    </select>
</div>


<!--
    <div class="form-group">
         <label for="post_image">Post Image</label>
          <input type="file"  name="image">
    </div>
-->

      <div class="form-group">
         <label for="post_tags">Username</label>
          <input type="text" class="form-control" name="username">
      </div>
      
      <div class="form-group">
         <label for="user_email">Email</label>
         <input type="email" class="form-control" name="user_email">
      </div>
      
      <div class="form-group">
         <label for="user_password">Password</label>
         <input type="password" class="form-control" name="user_password">
      </div>
      
       <div class="form-group">
          <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
      </div>


</form>