<?php


function studentCreate(int $id, string $student_fio, object $connection) : void{
    try{

        $sql = "INSERT INTO Students (ID, student_fio) VALUES ($id, $student_fio)";

        $affectedRowsNumber = $connection->exec($sql);
        echo "In Students appended $affectedRowsNumber strings";
    }

    catch(PDOException $e){
        echo "DB error: " . $e->getMessage();
    }
}