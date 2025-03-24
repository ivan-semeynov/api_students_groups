<?php

function readGroups(object $connection){
    try {
        $stmt = $connection->query("SELECT * FROM Groupp");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e){
        echo "DB error " . $e->getMessage();
    }
}