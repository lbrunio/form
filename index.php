<?php
function s_input($data) {
    return htmlspecialchars(strip_tags($data));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = s_input($_POST['name']);
    $alias = s_input($_POST['alias']);
    $age = intval($_POST['age']);
    $error_msg = '';
    $error_img = 'img/skull.png';
    $img_msg = ''; 

    if (isset($_FILES['fileUpload']) && $_FILES['fileUpload']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['fileUpload']['tmp_name'];
        $fileName = $_FILES['fileUpload']['name'];
        $fileSize = $_FILES['fileUpload']['size'];
        $fileType = $_FILES['fileUpload']['type'];

        if ($fileType === 'image/png' && $fileSize <= 10240) {
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . basename($fileName);

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $error_img = $dest_path;
                $img_msg = "Image uploaded";
            } else {
                $error_msg = 'Upload error.';
            }
        }
    }

   
    $weapons = [];
    if (isset($_POST['weapon1_cbox'])) $weapons[] = 'Maza';
    if (isset($_POST['weapon2_cbox'])) $weapons[] = 'Antorcha';
    if (isset($_POST['weapon3_cbox'])) $weapons[] = 'Martillo';
    if (isset($_POST['weapon4_cbox'])) $weapons[] = 'Látigo';

    
    $magic = isset($_POST['yn']) ? s_input($_POST['yn']) : 'Not especified';

    echo "<div style='display: flex; justify-content: center; align-items: flex-start;'>";
    echo "<div style='text-align: left; margin-right: 20px;'>";
    echo "<h1>Player data</h1>";
    echo "<p>Name: $name</p>";
    echo "<p>Alias: $alias</p>";
    echo "<p>Age: $age</p>";

    if (!empty($weapons)) {
        echo "<p>Weapons: " . implode(', ', $weapons) . "</p>";
    } else {
        echo "<p>No weapons.</p>";
    }

    echo "<p>Magic: $magic</p>";
    echo "</div>";

    echo "<div style='margin-left: 20px;'>";
    
    if ($error_img !== 'skull.png') {
        echo "<p>$img_msg</p>";
        echo "<img src='$error_img' alt='player_img' style='max-width:200px;'><br>";
    } else {
        echo "<p>No iamge.</p>";
        echo "<img src='skull.png' alt='skull' style='max-width:200px;'><br>";
        if ($error_msg) {
            echo "<p>$error_msg</p>";
        }
    }

    echo "</div>";
    echo "</div>";
} else {
    header("Location: form.html");
    exit();
}

