<?php include "includes/admin_header.php" ?>
<?php include "includes/bug_class.php" ?>
<div id="wrapper">
        <!-- Navigation -->
<?php include "includes/admin_navigation.php" ?>        
    <div id="page-wrapper">
        <div class="container-fluid">
        <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                    Your result:
                    </h1>
                   <?php           
    if(isset($_POST["submit"])){
        $search = $_POST['search'];
        if($search == ''){
            die("You searched nothing");
        }
        $bug_query = "SELECT * FROM bug WHERE bug_title LIKE '%$search%' OR bug_id LIKE '%$search%' ";
        //die('!!!!!' . $bug_query);
        //$user_query = "SELECT * FROM users WHERE user_firstname OR user_lastname OR username OR user_email LIKE '%$search%' ";
        $bug_query = "SELECT * FROM tags WHERE tag_name LIKE '%$search%' ";
        $search_bug_query = mysqli_query($connection, $bug_query);
       // $search_user_query = mysqli_query($connection, $user_query);
        //confirmQuery($search_user_query);
        confirmQuery($search_bug_query);
        
        $bug_count = mysqli_num_rows($search_bug_query);
        //$user_count = mysqli_num_rows($search_user_query);
        
        if($bug_count == 0){
            echo "<h1> no result </h1>";
        }else {
            while($row = mysqli_fetch_assoc($search_bug_query)){
                $bug = new Bug($row);
?>
    <!-- First Blog Post -->
    <h2>
        <a href="#">
           <?php
                echo $bug->title;
            ?>
        </a>
    </h2>
    <p class="lead">
        by <a href="index.php">
               <?php
                    echo $bug->title;
                ?>
            </a>
    </p>
    <p><span class="glyphicon glyphicon-time"></span> 
           <?php
                echo $bug->lastupdate;
            ?>
    </p>
    <hr>
    <img class="img-responsive" src="image/<?php echo $post_image ?>" alt="">
    <hr>
    <p>
        <?php
            echo $bug->description;
        ?>
    </p>
    <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

    <hr>
        
   <?php } 

        }
    }
    ?>      
    
<?php include "includes/admin_footer.php" ?>

