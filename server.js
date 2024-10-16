const express = require('express');
const mysql = require('mysql');

const app = express();
const port = 3000;

// MySQL connection configuration
const connection = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: '', // Enter your MySQL password here
  database: 'capstoneone' // Name of your database
});

// Connect to MySQL database
connection.connect((err) => {
  if (err) {
    console.error('Error connecting to MySQL database:', err);
    return;
  }
  console.log('Connected to MySQL database');
});

// Define API endpoints
app.get('/api/control', (req, res) => {
  connection.query('SELECT * FROM components_control', (err, results) => {
    if (err) {
      console.error('Error executing MySQL query:', err);
      res.status(500).json({ error: 'Internal server error' });
      return;
    }
    res.json(results);
  });
});

// Define a route to handle requests to the root URL ("/")
app.get('/', (req, res) => {
  res.send('Welcome to the API'); // Send a welcome message or HTML page
});

// Provide a default response for requests to undefined routes
app.use((req, res) => {
  res.status(404).send('Page not found'); // Send a 404 error message
});

// Start the server
app.listen(port, () => {
  console.log(`Server is running on http://localhost:${port}`);
});


// const express = require('express');
// const axios = require('axios');

// const app = express();
// const PORT = 3000;

// // Route to control the LED
// app.get('/led/:state', async (req, res) => {
//   const { state } = req.params;
//   try {
//     // Send HTTP request to ESP8266 to control LED
//     await axios.get(`http://192.168.1.9/led/${state}`);
//     res.send('LED control command sent');
//   } catch (error) {
//     console.error('Error controlling LED:', error.message);
//     res.status(500).send('Error controlling LED');
//   }
// });

// // Route to control the water pump
// app.get('/waterPump/:state', async (req, res) => {
//   const { state } = req.params;
//   try {
//     // Send HTTP request to ESP8266 to control water pump
//     await axios.get(`http://192.168.1.9/waterPump/${state}`);
//     res.send('Water pump control command sent');
//   } catch (error) {
//     console.error('Error controlling water pump:', error.message);
//     res.status(500).send('Error controlling water pump');
//   }
// });

// app.listen(PORT, () => {
//   console.log(`Server is running on port ${PORT}`);
// });