<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php  include "admin/functions.php"; ?>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $component = trim($_POST['component']);
    $level = trim($_POST['level']);
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    
    $image        = $_FILES["image"]['name'];
    $image_temp   = $_FILES['image']['tmp_name'];
    
    move_uploaded_file($image_temp, "/image/$image" );
    $error = [
        'username' => '',
        'email' => '',
        'password' => ''        
    ];
    if($username == ''){
        $error['username'] = 'Username can not be empty';
        
    }
    if(strlen($username) < 4){
        $error['username'] = 'Username needs longer';
    }
    
    
    if(is_username_duplicate($username)){
        $error['usernmae'] = 'Username already exists, pick another one';
        
    }
    
    if($email == ''){
        $error['email'] = 'Email can not be empty';
        
    }
    
    if(is_email_duplicate($email)){
        $error['email'] = 'Email already exists, pick another one';
    }
    
    if($password == ''){
        $error['password'] = 'Password can not be empty';
        
    }
    
    foreach($error as $key => $value){
        if(empty($value)){
            unset($error[$key]);
        }
    }
    
    if(empty($error)){
        register_user($username, $email, $password, $component, $level, $firstname, $lastname, $image) ;
        login_user($username, $password);
       
    }
}
?>
    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?> 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 ">
                <div class="form-wrap">
                <h1>Register</h1>
                   
                   <form class="form-horizontal" role="form" action="registration.php" method="post" id="login-form" autocomplete="off" enctype="multipart/form-data">
                    
                     <div class="form-group">
                           <label for="username" class="col-sm-2 control-label">Username</label>
                           <div class="col-sm-10">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username"
                                autocomplete="on" value="<?php echo isset($username) ? $username : '' ?>">
                                <p><?php echo isset($error['username']) ? $error['username']: '' ?></p>
                            </div>
                        </div>
                   
                     <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                           <div class="col-sm-10">
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($email) ? $email : '' ?>">
                            <p><?php echo isset($error['email']) ? $error['email']: '' ?></p>
                        </div>
                    </div>
                        
                      <div class="form-group">
                        <label for="firstname" class="col-sm-2 control-label">Firstname</label>
                        <div class="col-sm-10">
                          <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Your firstname">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="lastname" class="col-sm-2 control-label">Lastname</label>
                        <div class="col-sm-10">
                          <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Your lastname">
                        </div>
                      </div>
                                      
                      <div class="form-group">
                        <label for="level" class="col-sm-2 control-label">Your level</label>
                        <div class="col-sm-10">
                          <input type="text" name="level" id="level" class="form-control" placeholder="Your level">
                        </div>
                      </div>
                      
                      <div class="form-group">
                       <label for="image"  class="col-sm-2 control-label">Image</label>
                        <div class="col-sm-10">
                           <input type="file"  name="image">
                        </div>
                      </div>
                      
                      <div class="form-group">
                        <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                          <input type="password" name="password" id="key" class="form-control" placeholder="Password" value="<?php echo isset($password) ? $password : '' ?>">
                          <p><?php echo isset($error['password']) ? $error['password']: '' ?></p>
                        </div>
                      </div>
                       
                       
                      <div class="form-group">
                        <label for="department" class="col-sm-2 control-label ">Department</label>
                        <div class="col-sm-10">
                           <select id="inputState" class="form-control custom-select" name="component">
                           <option value='title'>Choose one...</option>
                            <?php
                            $query = "SELECT * FROM component";
                            $com_query = mysqli_query($connection,$query);
                            confirmQuery($com_query);
                            while($row = mysqli_fetch_assoc($com_query)){
                                $component_title = $row[component_title];
                                echo "<option value='{$component_title}'>$component_title</option>";
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                   
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block btn-primary" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
