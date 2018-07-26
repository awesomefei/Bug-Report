<?php
class Tag{
    var $id;
    var $name;
    function __construct($row){
       $this->id = $row['tag_id'];   
       $this->name = $row['tag_name'];  
    }
}

?>