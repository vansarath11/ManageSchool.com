<?php
// ALL Section
function getAllSections($conn){
    $sql = "SELECT * FROM section";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    if ($stmt->rowCount() >= 1){
        $sections = $stmt->fetchAll();
        return $sections;
    }else{
        return 0;
    }
}

    // All Section by ID
    function getSectioById($section_id, $conn){
        $sql = "SELECT * FROM section WHERE section_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$section_id]);

        if ($stmt->rowCount() == 1){
            $section = $stmt->fetch();
            return $section;
        }else{
            return 0;
        }
    }

    // The remove Section

    function removeSection($id, $conn){
        $sql = "DELETE FROM section 
                WHERE section_id=?";
        $stmt = $conn->prepare($sql);
        $re  = $stmt->execute([$id]);
        if ($re){
            return 1;
        }else{
            return 0;
        }
    }

?>