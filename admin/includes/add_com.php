 


<?php

if(isset($_POST['create_com'])) {
    $component_title       = $_POST['component_title'];
    
    $component_parent      = $_POST['component_parent'];

    $com_owners_id         = $_SESSION['user_id'];
    
    $query = "INSERT INTO component(component_parent, component_title, com_owners_id) ";

    $query .= "VALUES('{$component_parent}','{$component_title}',{$com_owners_id}) "; 

    $create_com_query = mysqli_query($connection, $query);  

    confirmQuery($create_com_query);
    
    
   }    
?> 

<form action="" method="post" enctype="multipart/form-data">    
    <div class="form-group">
         <label for="title">Component Title</label>
          <input type="text" class="form-control" name="component_title">
    </div>

    <div class="form-group">
       <p id="demo">123</p>
<script>

                    function myFunction() {
                        document.getElementById("demo").innerHTML = 5 + 6;

                    var x = document.createElement("SELECT");
                    x.setAttribute("id", "mySelect");
                    document.body.appendChild(x);

                    var z = document.createElement("option");
                    z.setAttribute("value", "volvocar");
                    var t = document.createTextNode("Volvo");
                    z.appendChild(t);
                    document.getElementById("mySelect").appendChild(z);
                }
             
</script>
        <label for="component_parent">Component Parent </label>
         <?php
        ?>

         <select name="component_parent" id="">
         <option value="null">NULL</option>
         <?php
            $query = "SELECT * FROM component WHERE component_parent = 'NULL'";
            $com_query = mysqli_query($connection,$query);
            confirmQuery($com_query);
            while($row = mysqli_fetch_assoc($com_query)){
                $com_title = $row['component_title'];
                $com_id = $row['component_id'];

                echo "<option value='{$com_id}' onclick='myFunction()'>{$com_title}</option>";
                
            }
         ?>
         </select>
    </div>
                
    <div class="form-group">
      <input class="btn btn-primary" type="submit" name="create_com" value="Create Component">
    </div>

</form>
