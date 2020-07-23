var long;
var lat;
var temperature = document.querySelector(".temperature");
var description = document.querySelector(".temperature-description");
//optional bits to be gotten later
var timezone;
var location;

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
                        //this overrides a cors errors
                        const proxy = "https://cors-anywhere.herokuapp.com/";
                        //?units=si is an optional api parameter so that it returns the values in different units, and ive set it so SI, the international system of units/metric. it can be recalculated to other
                        const api = `${proxy}https://api.darksky.net/forecast/546ecd9b28e0f4a6e09c01d3948e8142/${lat},${long}?units=si`
                        
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
            }
                else {
                    //edge case of browsers not supporting the location or it being denied
                    alert("Geolocation is not supported by this browser, or you need to allow location for this feature.");
                }
function skycons(icon, iconID){
    const skycons = new Skycons({color: "white"});
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

<?PHP
  if(defined("CRYPT_BLOWFISH") && CRYPT_BLOWFISH) {
    echo "CRYPT_BLOWFISH is enabled!";
  } else {
    echo "CRYPT_BLOWFISH is NOT enabled!";
  }
?> //this checks if Blowfish is enabled on the server