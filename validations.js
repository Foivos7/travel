document.addEventListener('DOMContentLoaded', function() {
   const registerForm = document.querySelector('form[action="register.php"]');
   if (registerForm) {
       registerForm.addEventListener('submit', function(event) {
           const firstName = document.getElementById('first_name').value;
           const lastName = document.getElementById('last_name').value;
           const username = document.getElementById('username').value;
           const password = document.getElementById('password').value;
           const email = document.getElementById('email').value;

           let valid = true;
           let message = "";

           if (!/^[a-zA-Z]+$/.test(firstName)) {
               valid = false;
               message += "First Name must contain only characters.\n";
           }
           if (!/^[a-zA-Z]+$/.test(lastName)) {
               valid = false;
               message += "Last Name must contain only characters.\n";
           }
           if (!/^[a-zA-Z0-9]+$/.test(username)) {
               valid = false;
               message += "Username must contain only alphanumeric characters.\n";
           }
           if (password.length < 4 || password.length > 10 || !/\d/.test(password)) {
               valid = false;
               message += "Password must be 4-10 characters long and contain at least one number.\n";
           }
           if (!/\S+@\S+\.\S+/.test(email)) {
               valid = false;
               message += "Email must be valid.\n";
           }

           if (!valid) {
               event.preventDefault();
               alert(message);
           }
       });
   }

   const createestateForm = document.querySelector('form[action="create_estate.php"]');
   if (createestateForm) {
       createestateForm.addEventListener('submit', function(event) {
           const title = document.getElementById('title').value;
           const location = document.getElementById('location').value;
           const rooms = document.getElementById('rooms').value;
           const pricePerNight = document.getElementById('price_per_night').value;

           let valid = true;
           let message = "";

           if (!/^[a-zA-Z\s]+$/.test(title)) {
               valid = false;
               message += "Title must contain only characters.\n";
           }
           if (!/^[a-zA-Z\s]+$/.test(location)) {
               valid = false;
               message += "Location must contain only characters.\n";
           }
           if (!/^\d+$/.test(rooms) || rooms <= 0) {
               valid = false;
               message += "Rooms must be a positive integer.\n";
           }
           if (!/^\d+$/.test(pricePerNight) || pricePerNight <= 0) {
               valid = false;
               message += "Price per Night must be a positive integer.\n";
           }

           if (!valid) {
               event.preventDefault();
               alert(message);
           }
       });
   }
});