<!DOCTYPE html>
<html lang="en">
<head>
    <style> 
        table {
            background-color:rgb(196, 164, 132,0.7);
            max-width: 600px;
        }
        th {
            background-color: #f2f2f2;
            padding: 8px;
            text-align: left;
        }
        td {
            padding: 8px;
            text-align: left;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
</head>
<body>
    <main>
        <section>
            <form method="POST">
                <label for="search">Search by City:</label>
                <input type="text" id="search" name="search">
                <button type="submit" name="submit">Search</button>
            </form>
            
<?php
if (isset($_POST['submit'])) {
    $search = urlencode($_POST['search']);
    $api_key = "0178a05a4eda46ade0bfb4a670d2fbe1";
    $api_url = "http://api.openweathermap.org/data/2.5/weather?q={$search}&units=metric&appid={$api_key}";

    $response = file_get_contents($api_url);
    $data = json_decode($response, true);

    if ($data && isset($data['main']) && isset($data['weather'])) {
        // Weather data variables
        $city = $data['name'];
        $temperature = $data['main']['temp'];
        $humidity = $data['main']['humidity'];
        $windspeed = $data['wind']['speed'];
        $pressure= $data['main']['pressure'];
        $description = $data['weather'][0]['description'];
        $current_day = date("Y-m-d");
            
        // Database connection
        $servername= "sql306.infinityfree.com";
        $username = "if0_34827783";
        $password = "QHa36EtQON";
        $db = "if0_34827783_weather_app";
        $conn = mysqli_connect($servername, $username, $password, $db);

        if (!$conn) {
            echo "Sorry, we failed to connect.";
        } else {
            // Insert data into the database
            $insert_sql = "INSERT INTO weather_data (city, temperature,humidity, windspeed, pressure,description, date ) VALUES ('$city', '$temperature', '$humidity', '$windspeed', '$pressure', '$description','$current_day')";
            $insert_result = mysqli_query($conn, $insert_sql);

            if ($insert_result) {
                echo "Weather data inserted into the database successfully.";
            } else {
                echo "Error inserting weather data into the database: " . mysqli_error($conn);
            }

            // Display weather data
            // echo "<h2>Weather Data for {$current_day} in City: {$_POST['search']}</h2>";
            echo "<table>";
            echo "<tr><th>city</th><th>temperature</th><th>humidity</th><th>windspeed</th><th>pressure</th><th>description</th><th>date</th></tr>";
            echo "<tr>";
            echo "<td>{$city} </td>";
            echo "<td>{$temperature} °C</td>";
            echo "<td>{$humidity} %</td>";
            echo "<td>{$windspeed}m/s</td>";
            echo "<td>{$pressure}hPa</td>";
            echo "<td>{$description} </td>";
            echo "<td>{$current_day} </td>";
            echo "</tr>";
            echo "</table>";
        }
    } else {
        echo "No weather data found for the entered city.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <style>
    body{
        background-image:url("https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.freepik.com%2Fphotos%2Fbackground&psig=AOvVaw2qg74ISSH7l77ZGIrhSawm&ust=1692015295419000&source=images&cd=vfe&opi=89978449&ved=0CBEQjRxqFwoTCJj-uqPO2YADFQAAAAAdAAAAABAL");
        background-color:rgb(144, 238, 144);
    } 

        table {
            background-color:rgba(196, 164, 132, 0.7);
            max-width: 600px;
        }
        th {
            background-color: #f2f2f2;
            padding: 8px;
            text-align: left;
        }
        td {
            padding: 8px;
            text-align: left;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
</head>
<body>
    <header style="font-size:18px;">
        weather of preston
    </header>
    <main>
        <section>
            <style>
                background-color:rgb(225, 168, 168);
            </style>
            <!-- Display weather data from database -->
            <?php
            $servername = "sql306.infinityfree.com";
            $username = "if0_34827783";
            $password = "QHa36EtQON";
            $db = "if0_34827783_weather_app";

            $conn = mysqli_connect($servername, $username, $password, $db);

            if (!$conn) {
                echo "Sorry, we failed to connect.";
            } else {
                $sql = "SELECT * FROM weather_data WHERE city ='Preston'";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                    echo "<table>";
                    echo "<tr><th>city</th><th>temperature</th><th>Humidity</th><th>windspeed</th><th>pressure</th><th>Description</th><th>date</th></tr>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['city'] . " </td>";
                        echo "<td>" . $row['temperature'] . "°C</td>";
                        echo "<td>" . $row['humidity'] . " %</td>";
                        echo "<td>" . $row['windspeed'] . "m/s</td>";
                        echo "<td>" . $row['pressure']. " hPa</td>";
                        echo "<td>" . $row['description'] . " </td>";
                        echo "<td>" . $row['date'] . " </td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                } else {
                    echo "No records found.";
                }
            }
            ?>
        </section>
    </main>
    <div>  <a href="http://rachitpoudelweather.42web.io/2358426_RachitPoude_index.html" style="font-size: 18px; color: black;"> ← view less</a> </div>
</body>
</html>