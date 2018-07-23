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
                    Welcome
                    <small>
                        <?php
                        if(isset($_SESSION['username'])){
                            echo $_SESSION['username'];
                        }
                        ?>
                    </small>
                    </h1>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                               <th><a href="assign_to_me.php?source=sortById">Id</a></th>
                                <th><a href="assign_to_me.php?source=sortByPriority">Priority</a></th>
                                <th>Title</th>
                                <th>Reporter</th>
                                <th>Assignee</th>
                                <th>Status</th>
                                <th><a href="assign_to_me.php?source=sortByLastModifiedTime">LastModified</a></th>
                            </tr>
                        </thead>
                        <tbody>

                                <?php
                                $target_user_query = "SELECT user_id FROM users WHERE username = '$_SESSION[username]'";

                                $select_target_user_id = mysqli_query($connection,$target_user_query);
                                while($row = mysqli_fetch_assoc($select_target_user_id)){
                                    $target_user_id = $row['user_id'];
                                }
                                //pagination
                                $dispay_per_page = 10;
                                if(isset($_GET['page'])){
                                    $page_num = $_GET['page'];
                                }else{
                                    $page_num = '';
                                }
                                if($page_num == '' ||$page_num == 1){
                                    $each_page_display_num = 0;
                                }else{
                                    $each_page_display_num = ($page_num * $dispay_per_page) - $dispay_per_page;

                                }

                                $total_page_count = get_total_page_count($target_user_id);
                                //query all bugs assigned to login suser
                                $query = "SELECT * FROM bug WHERE bug_assignee_id = $target_user_id ";

                                if(isset($_GET['source'])){
                                    $source = $_GET['source'];
                                }else{
                                    $source = '';
                                }
                                $query = appendSortBy($query, $source);
                                $query .= "LIMIT $each_page_display_num, $dispay_per_page ";

                                $select_bugs = mysqli_query($connection,$query);
                               
                            while($row = mysqli_fetch_assoc($select_bugs)){
                                $currentBug = new Bug($row);
                                //get reporter info by reporter id
                                 $earch_user_by_id_result = search_user_by_id($currentBug->reporter_id); 
                                 $reporter_email = mysqli_fetch_assoc($earch_user_by_id_result)['user_email'];
                                
                                echo "<tr>";
                                echo "<td> $currentBug->id</td>";
                                echo "<td> $currentBug->priority</td>";
                                echo "<td><a href='bug.php?b_id={$currentBug->id}'>$currentBug->title</a></td>";
                                echo "<td> $reporter_email</td>";
                                echo "<td>$currentBug->assignee_email</td>";
                                echo "<td>$currentBug->status</td>";
                                echo "<td>$currentBug->lastupdate</td>";
                                echo "<tr>";             
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <!-- /.row -->
        </div>
    <!-- /.container-fluid -->
    <div class="">
      <ul class="pagination">
        <?php
        for($current_page = 1; $current_page <= $total_page_count ; $current_page++){
            if($current_page == $page_num){
                echo "<li class='page-item active'><a class='page-link' href='assign_to_me.php?page={$current_page}'>{$current_page}</a></li>";
            }else{
                echo "<li><a href='assign_to_me.php?page={$current_page}'>{$current_page}</a></li>";

            }
        }
    ?>
      </ul>
    </div>
</div>

<?php include "includes/admin_footer.php" ?>

