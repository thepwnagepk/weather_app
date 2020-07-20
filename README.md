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

#  SQL and Accounts

The SQL in weatherappSQL should be imported after you create the database. In connect.php you can see the database its looking for is 'weatherapp', but you can call it whatever you want and change it there. Then you can import the SQL into that database and the 3 tables should be created

For an Account, there is one set up for you to test the login and favourites, the email is test@gmail.com and the password is 1234, the name of the account is John Doe. You can delete that anytime afterwards. There is no encryption on the database, be warned.

# To-Do

Database Encryption

CSS Styling: Modal -

Add Delete button to favourites, and make it scrollable

Trim down or remove open-iconic

Bonus: collapsing map button to make use of LocationIQ's map feature