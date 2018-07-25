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
        $query = "(SELECT * FROM bug WHERE bug_title LIKE '%$search%') ";
        //$query .= "(SELECT * FROM tags WHERE tag_name LIKE '%$search%') ";
        $search_query = mysqli_query($connection, $query);
        
        if(!$search_query){
            die('query failed' . mysqli_error($connection));
        }
        $count = mysqli_num_rows($search_query);
        if($count == 0){
            echo "<h1> no result </h1>";
        }else{
            while($row = mysqli_fetch_assoc($search_query)){
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

