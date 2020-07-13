var long;
var lat;
var temperature = document.querySelector(".temperature");
var description = document.querySelector(".temperature-description");
//optional bits to be gotten later
var timezone;
var locationname = document.querySelector(".locationname");
var locationsubtitle = document.querySelector(".locationsubtitle");

//when the window loads, ask if it can get location
// instead of () => i think i can put it all into a function and call that in the load, useful since i might want an if statement which checks wether or not it wants to find the current location or search for a bespoke/remote location.
window.addEventListener('load', () => {
    //if that works
    if (navigator.geolocation) {
        //go to showPosition
        navigator.geolocation.getCurrentPosition(position => {
            // set the lat and long variables to the one in the position object
            lat = position.coords.latitude;
            long = position.coords.longitude;

            var urlParams = new URLSearchParams(window.location.search);

            if (urlParams.has('lat') && urlParams.has('long') && urlParams.has('locationname') ) {
                lat = urlParams.get('lat');
                long = urlParams.get('long');                
                var newlocation = new String(urlParams.get('locationname'));
                var splitstring = newlocation.split(",");
                // this works: newlocation = newlocation.slice(0,newlocation.indexOf(','))   
                // locationname.textContent = newlocation;
                console.log(splitstring);
                locationname.textContent = splitstring[0];
                var subtitle = "";
                for (i = 1; i < splitstring.length; i++){
                    subtitle = subtitle += splitstring[i];
                }
                locationsubtitle.textContent = subtitle;
            }
            else
            {
                // Replace LOCATIONIQ_API_KEY with (unsurprisingly) your very own api key from LocationIQ
                // i have removed my own for security reasons (so it doest get hijacked and run up a massive bill in my name) 
                var settings2 = {
                  "async": true,
                  "crossDomain": true,
                  "url": "https://us1.locationiq.com/v1/reverse.php?key=LOCATIONIQ_API_KEY&lat=" + lat +"&lon=" + long + "&format=json",
                  "method": "GET"
                }

                $.ajax(settings2).done(function (response2) {
                  console.log(response2);
                    locationname.textContent = response2.address.city;
                });
                
            }


            //this overrides a cors errors
            const proxy = "https://cors-anywhere.herokuapp.com/";
            //?units=si is an optional api parameter so that it returns the values in different units, and ive set it so SI, the international system of units/metric. it can be recalculated to other
            //As with above, change YOUR_DARKSKY_API_KEY to your own actual key from Dark Sky
            const api = `${proxy}https://api.darksky.net/forecast/DARKSKY_API_KEY/${lat},${long}?units=si`

            fetch(api)
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    //create a log in the console with all the data
                    console.log(data);
                    //create multiple consts off of the currently section of the data
                    const apitemperature = data.currently.temperature;
                    const apidescription = data.currently.summary;
                    const apiicon = data.currently.icon;
                    //set DOM elements from the API
                    temperature.textContent = apitemperature + '°C';
                    description.textContent = apidescription;
                    
                    skycons(apiicon, document.querySelector('.icon'));
                
   
                })


        })
    } else {
        //edge case of browsers not supporting the location or it being denied
        alert("Geolocation is not supported by this browser, or you need to allow location for this feature.");
    }

    function skycons(icon, iconID) {
        const skycons = new Skycons({
            color: "white"
        });
        // replace all the - in the icon name to _ for the correct skycon id name, using /g replaces all
        const currentIcon = icon.replace(/-/g, "_").toUpperCase();
        skycons.play();
        return skycons.set(iconID, Skycons[currentIcon]);
    }


});



function showPosition(position) {
    //this shows block scope not working since the data for lat and long cant be accessed outside the block where it is declared, only the undefined global variable can be accessed here.
    document.getElementById("latlong").innerHTML = "Latitude: " + lat +
        "<br>Longitude: " + long;
}



//using the LocationIQ api to geocode responses from search bar
// key = 
// https://eu1.locationiq.com/v1/search.php?key=YOUR_PRIVATE_TOKEN&q=SEARCH_STRING&format=json is the link
