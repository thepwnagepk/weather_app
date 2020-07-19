# weather_app
Minimalist Weather App

# .gitignore

For obvious security reasons this site has gitignored a file with the API keys.
To get this site working you will need to create a config.js file, and whack in this code with your keys where the placeholders are

var config = {
    DarkskyKey: 'YOUR_DARKSKY_KEY',
    LocationIQKey : 'YOUR_LOCATIONIQ_KEY'
}

And it should work.