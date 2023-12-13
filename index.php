<?php

    $servername = "sql306.infinityfree.com";
    $username = "if0_34827783";
    $password = "QHa36EtQON";
    $dbname = "if0_34827783_weather_app";
    $city ="Preston";



$api_key = "0178a05a4eda46ade0bfb4a670d2fbe1";
$url = "https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${api_key}";
$json_data = file_get_contents($url);
$response_data = json_decode($json_data);
$weather_data = $response_data;

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$city1 = mysqli_real_escape_string($conn, $weather_data->name);
$temperature = mysqli_real_escape_string($conn, $weather_data->main->temp);
$humidity = mysqli_real_escape_string($conn, $weather_data->main->humidity);
$wind_speed = mysqli_real_escape_string($conn, $weather_data->wind->speed);
$pressure = mysqli_real_escape_string($conn, $weather_data->main->pressure);
$description = mysqli_real_escape_string($conn, $weather_data->weather[0]->description);
$today = date("Y/m/d"); // Fix the date format

$checkQuery = "SELECT * FROM weather_data WHERE city = '$city1'";
$checkResult = mysqli_query($conn, $checkQuery);

if (!$checkResult) {
    die("Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($checkResult) == 0) {
    $sql = "INSERT INTO weather_data (city, temperature, humidity, windspeed, pressure, description, date) 
            VALUES ('$city1', '$temperature', '$humidity', '$wind_speed', '$pressure', '$description', '$today')";

    if (mysqli_query($conn, $sql)) {
        // Data inserted successfully.
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    // Weather data for $city1 already exists.
}

$query = "SELECT * FROM weather_data";
$result = $conn->query($query);

if (!$result) {
    die("Error: " . mysqli_error($conn));
}

$data = array();
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>
