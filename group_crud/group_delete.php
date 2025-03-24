<?php

function groupDelete(int $id, object $connection){

    try{
        $stmt = $connection->prepare("DELETE FROM Groupp WHERE ID = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->rowCount();
    }

    catch (PDOException $e){
        echo 'DB error ' . $e->getMessage();
    }
}