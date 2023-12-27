<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentdb";

$connect = new mysqli($servername, $username, $password, $dbname);

if ($connect->connect_error) {
    die("Connection failed: " . $connect->connect_error);
}

if (isset($_POST["submit"])) {
    $image = $_FILES['image']['tmp_name'];
    $imgContent = file_get_contents($image);
    $imgName = $_FILES['image']['name'];

    $stmt = $connect->prepare("INSERT INTO images (image_name, image_data) VALUES (?, ?)");
    $stmt->bind_param("ss", $imgName, $imgContent);

    if ($stmt->execute()) {
        echo "Image uploaded Successfully";
    } else {
        echo "Error uploading image: " . $stmt->error;
    }

    $stmt->close();
}
$connect->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>

    img{
        width: 500px;
        height: 500px;
    }

</style>
<body>
<form method="POST" enctype="multipart/form-data">
    <input type="file" name="image">
    <input type="submit" value="Upload" name="submit">
</form>
<?php
    $connect = new mysqli($servername, $username, $password, $dbname);

    if($connect->connect_error){
        die("Connection failed: ". $connect->connect_error);
    }
    $sql = "SELECT image_data FROM images ORDER BY id DESC LIMIT 1";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo '<img src="data:image/*;base64,' . base64_encode($row['image_data']) . '" alt="Displayed Image">';
    } else {
        echo "Image not found";
    }
    $connect->close();

?>
</body>
</html>mysqlimysqli_driver