<?php
if(isset($_GET['edit_user'])){
   $the_user_id = $_GET['edit_user'];
   $query = "SELECT * FROM users WHERE user_id = $the_user_id ";
   $select_users_query = mysqli_query($connection,$query); 
    
    while($row = mysqli_fetch_assoc($select_users_query)){
         $user_id = $row['user_id'];
         $username = $row['username'];        
         $user_firstname = $row['user_firstname'];
         $user_lastname = $row['user_lastname'];
         $user_email = $row['user_email'];
         $user_role = $row['role'];
         $user_image = $row['user_image'];
    }
}

if(isset($_POST['edit_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];

//    $user_image        = $_FILES['image']['name'];
//    $user_image_temp   = $_FILES['image']['tmp_name'];

    $username           = $_POST['username'];
    $user_email         = $_POST['user_email'];
    $user_password      = $_POST['user_password'];

//    move_uploaded_file($post_image_temp, "../image/$post_image" );
    
    if(!empty($user_password)){
        $query_password = "SELECT user_password FROM users WHERE user_id = $the_user_id";
        $get_user_query = mysqli_query($connection, $query_password);
        confirmQuery($get_user_query);
       
        
        $row = mysqli_fetch_array($get_user_query);
        $db_user_password = $row['user_password'];
        
        if($db_user_password != $user_password){
            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' =>12));
        }
        $query = "UPDATE users SET ";
        $query .="username = '{$username}', ";
        $query .="user_firstname = '{$user_firstname}', ";
        $query .="user_lastname = '{$user_lastname}', ";
        $query .="role = '{$user_role}', ";
        $query .="user_email = '{$user_email}', ";
        $query .="user_password = '{$user_password}' ";
        $query .="WHERE user_id = '{$user_id}' ";

        $update_user = mysqli_query($connection,$query);
        confirmQuery($update_user);
        header("Location:users.php");
    }
    
}
    
?> 
<form action="" method="post" enctype="multipart/form-data">    

<div class="form-group">
     <label for="title">Firstname</label>
      <input type="text" class="form-control" name="user_firstname" value="<?php
       echo $user_firstname                                                 ?>">
</div>

<div class="form-group">
     <label for="title">Lastname</label>
      <input type="text" class="form-control" name="user_lastname" value="<?php
       echo $user_lastname                                                 ?>">
</div>


<div class="form-group">
     <select name="user_role" >
     <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
    <?php
       if($user_role == 'admin'){
           echo "<option value='subscriber'>subscriber</option>";
       }else{
           echo "<option value='admin'>admin</option>";
       }    
    ?>
          
    </select>
</div>

      <div class="form-group">
         <label for="post_tags">Username</label>
          <input value="<?php
       echo $username                                                 ?>" type="text" class="form-control" name="username">
      </div>
      
      <div class="form-group">
         <label for="user_email">Email</label>
         <input value="
      <?php
       echo $user_email                                                 ?>" type="email" class="form-control" name="user_email">
      </div>
      
      <div class="form-group">
         <label for="user_password">Password</label>
         <input autocomplete="off" type="password"  class="form-control" name="user_password">
      </div>
      
       <div class="form-group">
          <input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
      </div>


</form>