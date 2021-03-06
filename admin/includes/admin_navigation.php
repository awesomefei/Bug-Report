<nav class="navbar navbar-inverse navbar-fixed-top justify-content-between" role="navigation">
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
   <ul class="nav navbar-left top-nav">         
      <form class="form-inline" action="./search.php" method="post">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
        <button name ="submit" class="btn btn-outline-success my-2 my-sm-0" type="submit"><span class="glyphicon glyphicon-search"></span> Search</button>
      </form>
    </ul>
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
                        <a href="javascript:;" data-toggle="collapse" data-target="#other_dropdown"><i class="fas fa-chevron-down"></i></i>   Other </a>
                        <ul id="other_dropdown" class="collapse">
                            <li>
                                <a href="./reported_by_me.php">Reported By Me</a>
                            </li>
                            <li>
                                <a href="components.php?source=add_com">To be Continued...</a>
                            </li>
                        </ul>
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

                    <li>
                        <a href="./new_profile.php"><i class="fas fa-file-signature"></i> Profile</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>