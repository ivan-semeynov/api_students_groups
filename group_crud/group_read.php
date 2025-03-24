<?php

function readGroup(int $id, object $connection){

    try {
        $stmt = $connection->prepare("SELECT * FROM Groupp WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    catch (PDOException $e){
        echo "DB error " . $e->getMessage();
    }

}