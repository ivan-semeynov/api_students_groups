<?php

function groupUpdate(array $data, object $connection){

    try{
        $stmt = $connection->prepare('UPDATE Groupp SET group_name = :new_name, type = :new_type WHERE ID = :id');
        $stmt->execute([
            'id' => $data['id'],
            'new_name' => $data['new_name'],
            'new_type' => $data['new_type']
            ]);
        return $stmt->rowCount();
    }

    catch (PDOException $e){
        echo "DB error " . $e->getMessage();
    }

}