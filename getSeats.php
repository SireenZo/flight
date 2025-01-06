<?php


require_once 'db_connection.php';


$sql = "SELECT seatNumber, isOccupied FROM seats";
$result = mysqli_query($con, $sql);

if (!$result) {
    echo json_encode(['error' => 'Failed to fetch seat data: ' . mysqli_error($con)]);
    mysqli_close($con);
    exit();
}

$seats = [];
while ($row = mysqli_fetch_assoc($result)) {
    $seats[] = [
        'seatNumber' => $row['seatNumber'],
        'isOccupied' => (int)$row['isOccupied'], 
    ];
}


mysqli_close($con);


echo json_encode(['seats' => $seats]);
