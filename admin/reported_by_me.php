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
                    <p>These are reported by me</p>
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
                                    $each_page_display_num = get_each_page_display_num($dispay_per_page, $page_num);

                                }

                                $total_page_count = get_total_page_count($_SESSION['user_id']);
                                //query all bugs reported by login user
                                $query = "SELECT * FROM bug WHERE bug_reporter_id = $_SESSION[user_id] ";

                                if(isset($_GET['source'])){
                                    $source = $_GET['source'];
                                }else{
                                    $source = '';
                                }
                                $query = appendSortBy($query, $source);
                                $query .= "LIMIT $each_page_display_num, $dispay_per_page ";

                                $bugs = mysqli_query($connection,$query);
                               
                            while($row = mysqli_fetch_assoc($bugs)){
                                $current_bug = new Bug($row);
                                //get assignee info by reporter id
                                 $earch_user_by_id_result = search_user_by_id($current_bug->assignee_id); 
                                 $assignee_email = mysqli_fetch_assoc($earch_user_by_id_result)['user_email'];
                                
                                echo "<tr>";
                                echo "<td> $current_bug->id</td>";
                                echo "<td> $current_bug->priority</td>";
                                echo "<td><a href='bug.php?b_id={$current_bug->id}'>$current_bug->title</a></td>";
                                echo "<td> $_SESSION[email]</td>";
                                echo "<td>$assignee_email</td>";
                                echo "<td>$current_bug->status</td>";
                                echo "<td>$current_bug->lastupdate</td>";
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
        display_page($total_page_count,$page_num);
        ?>
      </ul>
    </div>
</div>

<?php include "includes/admin_footer.php" ?>

