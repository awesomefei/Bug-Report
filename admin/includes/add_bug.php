<?php include "includes/tag.php" ?>
<?php
    if(isset($_POST['create_tag'])) {
        $name = $_POST['bug_name'];
        $tag_query = get_tag_by_name_query($name);
        $tag_count = get_tag_count($tag_query);

        if($name == '') {
            echo "<script>alert('The Field cannot be empty')</script>";
        } else if($tag_count > 0) {
            echo "<script>alert('You already have this tag')</script>";
        } else {
            create_tag($name);
            echo "<p class='bg-success'>tag created</p>";
        }
    }

    if(isset($_POST['create_bug'])) {
        $bug_tags = $_POST["bug_tag_name"];
        $bug_title = $_POST['bug_title'];
        $assingee_email = $_POST['bug_assignee_email'];
        $assignee_id = get_user_id_by_email($assingee_email);
        $bug_type = $_POST['bug_type'];
        $bug_description = $_POST['bug_description'];
        $reporter_id = $_SESSION['user_id'];
        $bug_eta = $_POST['bug_close_date'];
        $bug_priority = $_POST['bug_priority'];    

        $insert_query = "INSERT INTO bug(bug_title, bug_assignee_id, "
            . "bug_open_date, lastupdate, priority, bug_close_date, "
            . "bug_reporter_id, description) "
            . "VALUES('{$bug_title}', {$assignee_id}, now(), now(), "
            . "'{$bug_priority}', '{$bug_eta}', {$reporter_id}, "
            . "'{$bug_description}') "; 

        $create_bug_query = mysqli_query($connection, $insert_query);  

        confirmQuery( $create_bug_query);

        // Get the lastest bug id
        $bug_id = get_primary_id();

        for($i = 0; $i < sizeof($bug_tags); $i++) {
            $tag_id = get_tag_id_by_tag_name($bug_tags[$i]);            
            // Insert new bug-tag pair
            create_bug_tag($bug_id, $tag_id);
        }

        echo "<p class='bg-success'>bug created</p>";
       }    
?> 
<form action="" method="post" enctype="multipart/form-data">    
    <div class="form-group">
        <label for="title">Bug Title:</label>
        <input type="text" class="form-control" name="bug_title">
    </div>

    <div class="form-group">
        <label for="title">Bug Assignee:</label>
        <input type="text" name="bug_assignee_email">
    </div>

    <div class="form-group">
        <label for="bug_priority">Bug Priority:</label>
        <select name="bug_priority">
             <option value="1">1</option>
             <option value="2">2</option>
             <option value="3">3</option>
        </select>
    </div>

    <div class="form-group">
        <label for="related_department">Related Department:</label>
        <select name="related_department">
            <?php
            $department_query = get_all_departments();
            while($row = mysqli_fetch_assoc($department_query)){
                $dep_title = $row['department_title'];
                $dep_id = $row['department_id']; 
                echo "<option value='{$dep_id}'>{$dep_title}</option>";
            }
            ?>
        </select>
    </div>
 
    <div class="form-group">
        <label for="bug_type">Bug Type:</label>
        <select name="bug_type">
            <?php
                // Get bug type enums from table
                $bug = "bug";
                $bug_type = "bug_type";
                get_enum(bug, bug_type);
            ?>
       </select>
    </div>
    
    <div class="form-group">
        <label for="tag_name">Tags:</label>
        <select name='tag_id' id="tag_id">
            <?php
                $query = "SELECT * FROM tags ORDER BY tag_name";
                $tags_query = mysqli_query($connection,$query);
                confirmQuery($tags_query);
                while($row = mysqli_fetch_assoc($tags_query)){
                    $tag = new Tag($row);
                    echo "<option value='{$tag->id}'>{$tag->name}
                    </option>";
                }
            ?>
        </select>
        <input type="button"  class="btn btn-primary mb-2" name="add_tag" 
        id="addTagBtn" value="Add Tag" onclick="addTag()"></input>
    </div>
    
    <div class="form-group" id="addTagDiv">
        
    </div>
 
    <script>
        var tagNameList = []; 
        var tagIdList = [];
        var crossId = 0;
        var parent = document.getElementById("addTagDiv");
        var js_tag_id = document.getElementById("tag_id").value;
        
        function getSelectedText(elementId) {
            var elt = document.getElementById(elementId);
            if (elt.selectedIndex == -1) {
                return null;
            }
            return elt.options[elt.selectedIndex].text;
        }
        
         function removeRecord(i) {
            tagNameList.splice(i, 1);
            var tags = "";
            for (var i = 0; i < tagNameList.length; i++) {
                tags += tagNameList[i] 
                    +  "<a href='#' onClick='removeRecord(" 
                    + i 
                    + ");'> &times; </a><br>";
            };
            document.getElementById('addTagDiv').innerHTML = tags;
        }

        function addTag() {
            var optionText = getSelectedText('tag_id');
            tagNameList.push(optionText);
            
            var newTag = optionText
                + "<a href='#' onClick='removeRecord(" 
                + (tagNameList.length - 1)
                + ");'> &times; </a><br>" 
            document.getElementById('addTagDiv').innerHTML += newTag;
        }
    </script>
    
     <div class="form-group ">
        <label for="related_department">Or create a new Tag: </label>
        <input type="text"  name="bug_name" placeholder="New Tag">
        <button type="submit" class="btn btn-primary mb-2" 
            name="create_tag">Create Tag</button>
    </div>
 
  
    <div class="form-group">
        <label for="bug_close_date">ETA:</label>
        <input class="form-control" type="date" id="example-date-input" 
            name="bug_close_date">
    </div>

    <div class="form-group">
        <label for="post_content">Bug Description: </label>
        <textarea class="form-control" name="bug_description" id="body" 
            cols="30" rows="10">
        </textarea>
    </div>

    <div class="form-group">
      <input class="btn btn-primary" type="submit" name="create_bug" 
          value="Create Bug">
    </div>  
</form>