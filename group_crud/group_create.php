<?php

//unfinished
function groupCreate(array $data, object $connection){

    try{
        $stmt = $connection->prepare("INSERT INTO Groupp (group_name, type) VALUES (:group_name, :type)");
        $stmt->execute(['group_name' => $data['group_name'], 'type' => $data['type']]);
        return $connection->lastInsertId();
    }

    catch(PDOException $e){
        echo "DB error: " . $e->getMessage();
    }

}



