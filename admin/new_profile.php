<?php include "includes/admin_header.php" ?>
<?php   
   if(isset($_SESSION['username'])){
       $username = $_SESSION['username'];
       $query = "SELECT * FROM users WHERE username = '{$username}' ";
       $select_user_profile_query = mysqli_query($connection, $query);
       while($row = mysqli_fetch_array($select_user_profile_query)){
         $user_id = $row['user_id'];
         $username = $row['username'];        
         $user_firstname = $row['user_firstname'];
         $user_lastname = $row['user_lastname'];
         $user_email = $row['user_email'];
         $user_level = $row['user_level'];
         $user_image = $row['user_image'];
           //use component id to get component title
         $user_com_id = $row['component_id'];
         $com_query = "SELECT component_title FROM component WHERE component_id = $user_com_id ";
         $user_com_query = mysqli_query($connection, $com_query);
         confirmQuery($user_com_query);
         while($user_com_row = mysqli_fetch_array($user_com_query)){
             $user_com_title = $user_com_row[component_title];
         }        
       }
   }
?>

<div id="wrapper">
        
        <!-- Navigation -->
<?php include "includes/admin_navigation.php" ?>        
<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to Profile
                    <small><?php
                if(isset($_SESSION['username'])){
                    echo $_SESSION['username'];
                }
                ?></small>
                </h1>
            </div>
      
                <div class="row">
                    <div class="col-lg-2">
                        <img src="../image/<?php echo $user_image ?>" alt="..." class="img-thumbnail" width="204" height="236">
                    </div>
                    <div class="col-lg-8">
                     <dl class="row">
                          <dt class="col-lg-3">Name:</dt>
                          <dd class="col-lg-9">
                          <?php echo $user_firstname . ' ' .$user_lastname ?>
                          </dd>

                          <dt class="col-lg-3">Email: </dt>
                          <dd class="col-lg-9">
                          <?php echo $user_email ?>   
                          </dd>

                          <dt class="col-lg-3">Username: </dt>
                          <dd class="col-lg-9">
                          <?php echo $username ?>   
                          </dd>

                          <dt class="col-lg-3">Department: </dt>
                          <dd class="col-lg-9">
                          <?php echo $user_com_title ?>
                          </dd>

                          <dt class="col-lg-3">Level: </dt>
                          <dd class="col-lg-9">
                          <?php echo $user_level ?>
                          </dd>

                        </dl>
                    </div>
                    <div class="col-lg-2">
                       <div class="card bg-light mb-3 border border-dark" style="max-width: 18rem;">
                          <div class="card-body">
                            <h5 class="card-title">Activity: </h5>
                            <div class="list-group">
                              <a href="#" class="list-group-item list-group-item-action active"><i class="fas fa-edit"></i> Edit Profile
                              </a>
                              <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-question-circle"></i> Help</a>
                              <a href="#" class="list-group-item list-group-item-action"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                          </div>
                        </div>
                    </div>
                </div> 
            </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>
