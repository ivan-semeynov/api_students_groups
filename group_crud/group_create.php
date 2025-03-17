<?php

//unfinished
function groupCreate(int $id, string $group_name,string $type, object $connection) : void{
    try{

        $sql = "INSERT INTO Groupp (ID, group_name) VALUES ($id, $group_name,)";

        $affectedRowsNumber = $connection->exec($sql);
        echo "In Students appended $affectedRowsNumber strings";
    }

    catch(PDOException $e){
        echo "DB error: " . $e->getMessage();
    }
}



