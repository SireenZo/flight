<?php

require_once 'db_connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $data['userId'];
    $flightId = $data['flightId'];
    $passengerName = $data['passengerName'];
    $numberOfAdults = $data['numberOfAdults'];
    $numberOfChildren = $data['numberOfChildren'];
    $passengerSeat = $data['passengerSeat'];
    $hasInsurance = $data['hasInsurance'];
    $selectedClass = $data['selectedClass'];
    $isRoundTrip = $data['isRoundTrip'];

    
    $stmt = $con->prepare("INSERT INTO bookings (user_id, flight_id, passenger_name, number_of_adults, number_of_children, passenger_seat, has_insurance, selected_class, is_round_trip) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("iissiisss",$userId, $flightId, $passengerName, $numberOfAdults, $numberOfChildren, $passengerSeat, $hasInsurance, $selectedClass, $isRoundTrip);

    if ($stmt->execute()) {
        $response = ['status' => 'success', 'message' => 'Booking successful'];
    } else {
        $response = ['status' => 'error', 'message' => 'Error inserting data: ' . $stmt->error];
    }

    
    $stmt->close();
} else {
    http_response_code(405); 
    $response = ['status' => 'error', 'message' => 'Method not allowed'];
}

$con->close();


echo json_encode($response);
?>
