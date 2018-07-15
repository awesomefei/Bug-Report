<form action="" method="post">
<table class="table table-bordered table-hover">
   <div id="bulkOptionsContainer" class="col-xs-4">
       <select name="bulk_options" id="" class="form-control"> 
           <option value="">Select Options</option>
           <option value="published">Publishe</option>
           <option value="draft">Draft</option>
           <option value="delete">Delete</option>
        </select>
       
   </div>
   <div class="col-xs-4">
       <input type="submit" name="submit" class="btn btn-success" value="Apply">
       <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
   </div>
    <thead>
        <tr>
            <th><input type="checkbox" id="selectAllbox"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>Edit</th>
            <th>Delete</th>

        </tr>
    </thead>
<tbody>
<?php
    $query = 'SELECT * FROM posts';
    $select_posts = mysqli_query($connection,$query);                                    
    while($row = mysqli_fetch_assoc($select_posts)){
         $post_title = $row['post_title'];
         $post_id = $row['post_id'];
         $post_author = $row['post_author'];        
         $post_category_id = $row['post_category_id'];
         $post_status = $row['post_status'];
         $post_image = $row['post_image'];
         $post_tags = $row['post_tags'];
         $post_date = $row['post_date'];
         $post_comment_count = $row['post_comment_count'];
        
        echo "<tr>";
?>
        <td><input type='checkbox' class='checkBoxs' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>;
<?php
        echo "<td>$post_id</td>";
        echo "<td>$post_author</td>";
        echo "<td>$post_title</td>";
        
        $query = "SELECT * FROM category WHERE cat_id = {$post_category_id}";
        $select_cat_id = mysqli_query($connection,$query);

        while($row = mysqli_fetch_assoc($select_cat_id)){
            $cat_title = $row['cat_title'];
            $cat_id = $row['cat_id'];
            echo "<td>{$cat_title}</td>";  
        }
        echo "<td>$post_category_id</td>";
        echo "<td>$post_status</td>";
        echo "<td><img width=100 src='../image/$post_image' alt='image'></td>";
        echo "<td>$post_tags</td>";
        echo "<td>$post_comment_count</td>";
        echo "<td>$post_date</td>";
        echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>";
        echo "<td><a class='btn btn-info'' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
        
        ?>
        <form method="post">
            <input type="hidden" name="post_id" value="<?php echo $post_id ?>">
            <?php
            echo '<td><input class="btn btn-danger" value="Delete" type="submit" name="delete"></td>'         
            ?>
            
        </form>
        <?php
          
        echo "<tr>";

    }
    
    ?>
                                
                            </tbody>
                        </table>
</form>                        



<?php
//if(isset($_POST['checkBoxArray'])){
//    foreach($_POST['checkBoxArray'] as $postValueId){
//        $bulk_options = $_POST['bulk_options'];
//        switch($bulk_options){
//                case 'published':
//                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id= {$postValueId} ";
//                $update_to_published = mysqli_query($connection, $query);
//                confirmQuery($update_to_published);
//                break;
//                
//                case 'draft':
//                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id= {$postValueId} ";
//                $update_to_draft = mysqli_query($connection, $query);
//                confirmQuery($update_to_draft);
//                break;
//                
//                case 'delete':
//                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id= {$postValueId} ";
//                $update_to_delete = mysqli_query($connection, $query);
//                confirmQuery($update_to_delete);
//                break;
//        }
//    }
//}

?>
