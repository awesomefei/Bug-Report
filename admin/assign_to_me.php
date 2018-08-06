<?php include "includes/admin_header.php" ?>
<?php include "includes/bug_class.php" ?>
<div id="wrapper">
<?php include "includes/admin_navigation.php" ?>        
    <div id="page-wrapper">
        <div class="container-fluid">
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
                    <?php 
                        include "includes/assign_to_me_coms/bug_table.php"
                    ?> 
                </div>
            </div>
        </div>
    <div class="">
      <ul class="pagination">
        <?php display_page($total_page_count, $page_num); ?>
      </ul>
    </div>
</div> 

<?php include "includes/admin_footer.php" ?>

