const searchInput= document.getElementById("search-bar");
const searchBtn = document.getElementById('SearchBtn');
const image = document.getElementById('icon');
const d = new Date().toJSON().slice(0,10);

// For Default city

  async function getWeather_default() {
    var responce = await fetch (`https://api.openweathermap.org/data/2.5/weather?q=Preston&appid=0178a05a4eda46ade0bfb4a670d2fbe1`)
    var data = await responce.json();
    console.log(data);
    const weatherData_Default= {
      city: data.name,
      temp: Math.round(data.main.temp - 273.15),
      humidity: data.main.humidity,
      pressure: data.main.pressure,
      wind: data.wind.speed,
      description: data.weather[0].description,
      date: new Date().toJSON().slice(0, 10),
    };
    
    localStorage.setItem('weatherData_default', JSON.stringify(weatherData_Default));
    
    if (!navigator.onLine) {
      const parsedWeatherData = JSON.parse(localStorage.getItem('weatherData_default'));
      if (parsedWeatherData) {
        document.getElementById('celcius').innerHTML = parsedWeatherData.temp + "° C";
        document.getElementById('city').innerHTML = parsedWeatherData.city;
        document.getElementById('humidity').innerHTML = parsedWeatherData.humidity + "%";
        document.getElementById('win').innerHTML = parsedWeatherData.wind + " Km/h";
        document.getElementById('press').innerHTML = parsedWeatherData.pressure + " hPa";
        document.getElementById('description').innerHTML = parsedWeatherData.description;
        document.getElementById("date").innerHTML = parsedWeatherData.date;
      } else {
        console.log("No weather data found.");
      }
    }
  console.log(weatherData_Default);

    document.getElementById('celcius').innerHTML= Math.round((data.main.temp -273.15)) +"° C";
    document.getElementById('city').innerHTML= data.name;
    document.getElementById('humidity').innerHTML= data.main.humidity + "%";
    document.getElementById('win').innerHTML= data.wind.speed + "Km/h";
    document.getElementById('press').innerHTML= data.main.pressure+ "hPa";
    document.getElementById('description').innerHTML=data.weather[0].description;
    document.getElementById("date").innerHTML = d;

    switch (data.weather[0].main) {
      case 'Clouds':
          image.src = 'cloudy-9953.jpg';
            break;
        case 'Clear':
          image.src = 'Sunny.png';
            break;
        case 'Rain':
          image.src ='Rainny.png';
            break;
        case'thunder':
          image.src='Thunder.png';
            break;
                
    }
    
  }
getWeather_default();


//For the Searched City

async function getWeather_City(city) {
    
  if (window.navigator.onLine) { 
    console.log("Data comming from Online"); 
    var api_key = "0178a05a4eda46ade0bfb4a670d2fbe1";
    var responce = await fetch(`https://api.openweathermap.org/data/2.5/weather?q=${city}&appid=${api_key}`)
    if(responce.status == "404"){
      document.getElementById("error").style.display="block"; 
    }
    else{
    var data = await responce.json();
    console.log(data);

    
    localStorage.setItem(city, JSON.stringify(data));
    
    if (!navigator.onLine) {
      const parsedWeatherData = JSON.parse(localStorage.getItem('weatherData'));
      if (parsedWeatherData) {
        document.getElementById('celcius').innerHTML = parsedWeatherData.temp + "° C";
        document.getElementById('city').innerHTML = parsedWeatherData.city;
        document.getElementById('humidity').innerHTML = parsedWeatherData.humidity + "%";
        document.getElementById('win').innerHTML = parsedWeatherData.wind + " Km/h";
        document.getElementById('press').innerHTML = parsedWeatherData.pressure + " hPa";
        document.getElementById('description').innerHTML = parsedWeatherData.description;
        document.getElementById("date").innerHTML = parsedWeatherData.date;
      } else {
        console.log("No weather data found.");
      }
    }
  

    document.getElementById('celcius').innerHTML= Math.round((data.main.temp -273.15))+ "° C";
    document.getElementById('city').innerHTML= data.name;
    document.getElementById('humidity').innerHTML= data.main.humidity + "%";
    document.getElementById('win').innerHTML= data.wind.speed + "Km/h";
    document.getElementById('press').innerHTML= data.main.pressure+ "hPa";
    document.getElementById('description').innerHTML=data.weather[0].description;
    document.getElementById("date").innerHTML = d;

    switch (data.weather[0].main) {
      case 'Clouds':
          image.src = 'cloudy-9953.jpg';
            break;
        case 'Clear':
          image.src = 'Sunny.png';
            break;
        case 'Rain':
          image.src ='Rainny.png';
            break;
        case'thunder':
          image.src='Thunder.png';
            break;  
      
    }
    localStorage.setItem(city.toLowerCase(), JSON.stringify(data));
    document.getElementById("error").style.display="none";          
    }
    
    console.log(data);
  }
  if (!window.navigator.onLine) {
    console.log("OFFLINE: Showing data from LocalStorage");

    const localWeather = localStorage.getItem(city);
    const localData = JSON.parse(localWeather);
    console.log(localData);


    // Update your HTML elements using localData values
    document.getElementById('celcius').innerHTML= Math.round((localData.main.temp -273.15))+ "° C";
    console.log(document.getElementById('celcius').innerHTML)
    document.getElementById('city').innerHTML= localData.name;
    document.getElementById('humidity').innerHTML= localData.main.humidity + "%";
    document.getElementById('win').innerHTML= localData.wind.speed + "Km/h";
    document.getElementById('press').innerHTML= localData.main.pressure+ "hPa";
    document.getElementById('description').innerHTML=localData.weather[0].description;
    document.getElementById("date").innerHTML = d;

    switch (localData.weather[0].main) {
      case 'Clouds':
          image.src = 'cloudy-9953.jpg';
            break;
        case 'Clear':
          image.src = 'Sunny.png';
            break;
        case 'Rain':
          image.src ='Rainny.png';
            break;
        case'thunder':
          image.src='Thunder.png';
            break;  
    }
}
}
  searchBtn.addEventListener('click', ()=>{
    getWeather_City(searchInput.value);
})