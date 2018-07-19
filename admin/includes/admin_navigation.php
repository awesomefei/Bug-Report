<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                 <li>
                    <a href="../index.php">Home Site </a>
                </li>
                
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php
                        if(isset($_SESSION['username'])){
                            echo $_SESSION['username'];
                        }
                        ?>
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="../includes/logout.php"><i class="fa fa-fw fa-power-off"></i>Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                   <li>
                        <a href="bugs.php?source=add_bug"><i class="fas fa-bug"></i> Compose</a>
                    
                    <li class="active">
<!--                       <a href="../admin/assign_to_me.php">-->
                      <a href="./assign_to_me.php">
                       <i class="fa fa-fw fa-wrench"></i> Assign To me</a>
                    </li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#coms_dropdown"><i class="fas fa-chevron-down"></i></i>   Components </a>
                        <ul id="coms_dropdown" class="collapse">
                            <li>
                                <a href="./components.php">View All Coms</a>
                            </li>
                            <li>
                                <a href="components.php?source=add_com">Add Coms</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="../admin/dataAnalysis.php"><i class="fa fa-database" aria-hidden="true"></i>
                         Data Analysis</a>
                    </li>

                    <li >
                        <a href="comments.php"><i class="fa fa-fw fa-file"></i> Comments</a>
                    </li>
                    
                   <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#users_dropdown"><i class="fas fa-user"></i> Users<i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="users_dropdown" class="collapse">
                            <li>
                                <a href="./users.php">view all users</a>
                            </li>
                            <li>
                                <a href="users.php?source=add_user">Add User</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="./new_profile.php"><i class="fas fa-file-signature"></i> Profile</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>