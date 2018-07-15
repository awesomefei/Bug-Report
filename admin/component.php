<?php include "includes/admin_header.php" ?>
<div id="wrapper">

    <!-- Navigation -->
<?php include "../admin/includes/admin_navigation.php" ?>        
        <div id="page-wrapper">
            <div class="container-fluid">

                <!-- Page Heading -->
    <div class="row">

<?php
    $targetUseremail;
    $targetFirstname;
    $targetLastname;
    $bug_comment_count;
    if(isset($_GET['b_id'])){
        $the_bug_id = $_GET['b_id'];
    }

    $query = "SELECT * FROM bug WHERE bug_id = $the_bug_id ";
    $select_all_bugs_query = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_all_bugs_query)){
        $bug_title = $row['bug_title'];
        $bug_description = $row['description'];
        $bug_comment_count = $row['comment_count'];
        //bug_reporter_id
        $bugReorterQuery="SELECT * FROM users WHERE user_id = '$row[bug_reporter_id]'";
            $select_user = mysqli_query($connection,$bugReorterQuery);
            while($row1 = mysqli_fetch_assoc($select_user)){
                 $targetUseremail = $row1['user_email'];
                 $targetFirstname = $row1['user_firstname'];
                 $targetLastname = $row1['user_lastname'];
            }
        //bug_assignee_id
        $bug_priority = $row['priority'];
        $bug_status = $row['status'];
        $bug_lastupdate = $row['lastupdate'];
?>
                <!-- First Blog Post -->
        <div class="col-lg-4">
            <h4 class="page-header">
              ID:<?php echo $the_bug_id ?>
        </h4>
        </div>
        <div class="col-lg-4">
            <h4 class="page-header">
              Title:
               <?php
                    echo $bug_title;
                ?>
        </h4>
        </div>
        <div class="col-lg-4">
            <a href="dataAnalysis.php"><h4 class="page-header"><i class="fas fa-chart-bar fa-lg"></i>
            </a></h4>
        </div> 
    </div>
        
     <div class="row">
        <div class="col-lg-8">   
    <div class="row">
        <div class="media col-lg-10">
          <img class="align-self-start mr-3" src="../image/profile.jpg" alt="Generic placeholder image" style="width:50px;height:50px;">
          <div class="media-body">
            <h5 class="mt-0"><?php echo $targetFirstname . " " . $targetLastname; ?></h5>
            to me
          </div>
        </div>
        <div class="col-lg-2">
         <p><span class="glyphicon glyphicon-time"></span> 
                       <?php
                            echo $bug_lastupdate;
                        ?>
         </p>
        </div>
    </div>
        
        <p><font size="3">
            <?php
                echo $bug_description;
            ?>
        </font></p>
        <hr>
        
   <?php } ?>
                   <!-- Posted Comments -->
<?php
$bug_comment_count_show = 1;
$query = "SELECT * FROM comment WHERE bug_id = {$the_bug_id} ";
$query .= "ORDER BY comment_id DESC ";
                
$selct_comment_query = mysqli_query($connection, $query);
if(!$selct_comment_query){
    die("message is" .mysqli_error($connection));
}                
while($row = mysqli_fetch_array($selct_comment_query)){
    $comment_date = $row['comment_date'];
    $comment_content = $row['comment_content'];
    $comment_author_id = $row['user_id'];
    $userQuery = "SELECT * FROM users WHERE user_id = {$comment_author_id} ";
    $selct_user_query = mysqli_query($connection, $userQuery);
    while($row1 = mysqli_fetch_array($selct_user_query)){
        $selct_user_firstname = $row1['user_firstname'];
        $selct_user_lastname = $row1['user_lastname'];

        $selct_user_email = $row1['user_email'];
        $selct_user_Image = $row1['user_image'];

?>

   <!-- Comment -->
 <div class="row">
        <div class="media col-lg-10">
          <img class="align-self-start mr-3" src="../image/<?php
        echo $selct_user_Image
        ?>" alt="Generic placeholder image" style="width:50px;height:50px;">
          <div class="media-body">
            <h5 class="mt-0"><?php echo $selct_user_firstname . " " . $selct_user_lastname; ?>
            <a href="#">#<?php 
                echo $bug_comment_count_show++;
                ?></a>
            </h5>
          </div>
        </div>
        <div class="col-lg-2">
         <p><span class="glyphicon glyphicon-time"></span> 
               <?php
                    echo $comment_date;
                ?>
         </p>
        </div>
    </div>
    <p font="3"><?php echo $comment_content ?></p>
     <?php               
    }  
}
?>

 <!-- Blog Comments -->
<?php
if(isset($_POST['create_comment'])){
    $the_bug_id = $_GET['b_id'];
    $comment_author = $_SESSION['firstname'];
    $comment_content = $_POST['comment_content'];
    if(!empty($comment_content)){
        
        $query = "INSERT INTO comment (bug_id, user_id, comment_content, comment_date) ";
    
        $query .= "VALUES ($the_bug_id , '$_SESSION[user_id]', '{$comment_content}', now())";
        $create_comment_query = mysqli_query($connection, $query);
        if(!$create_comment_query){
            die('QUERY FAILED' . mysqli_error($connection));
        }
    $bug_comment_count_query = "UPDATE bug SET comment_count = $bug_comment_count+1 ";
    $increase_comment_query = mysqli_query($connection, $bug_comment_count_query);
    if(!$increase_comment_query){
        die('QUERY FAILED' . mysqli_error($connection));
    }
    redirect("/BugReport/admin/bug.php?b_id={$the_bug_id}");
        
    }else{
        echo"<script>alert('Fields cannot be empty')</script>";
    }
}
?>
                <!-- Comments Form -->
    <div class="well">
        <form role="form" action="" method="post">

            <div class="form-group">
                <textarea name="comment_content" class="form-control" rows="10" id="body"></textarea>

            </div>

            <button type="submit" name="create_comment" class="btn btn-primary">Send</button>
        </form>
    </div>
<hr>
</div>
           
    <div class="col-lg-4 well"></div>       
        </div>
                <!-- /.row -->

    </div>
            <!-- /.container-fluid -->

</div>
        <!-- /#page-wrapper -->

<?php include "../admin/includes/admin_footer.php" ?>

