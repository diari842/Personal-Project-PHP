<?php include "config.php"; 

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $username = $_POST["username"]; 
      $email = $_POST["email"]; 
       $password = password_hash($_POST["password"], PASSWORD_DEFAULT); 
        
        
        
         $sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
         
         if ($conn->query($sql) === TRUE) {
             echo "Signup successful! <a href='login.php'>Login here</a>";
              } else {
                 echo "Error: " . $conn->error;
                  }
                } 
                ?> 
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Signup</title>
                </head> 
                <body> 
                    <h2>Signup</h2> 
                    <form method="POST"> 
                        <label>Username:</label> 
                        <input type="text" name="username" required><br> 
                        
                        <label>Email:</label>
                        <input type="email" name="email" required><br> 
                        
                        <label>Password:</label> 
                        <input type="password" name="password" required><br> 
                        
                        <button type="submit">Signup</button> 
                    </form> 
                </body> 
                </html>



// Log In page
<?php
include "config.php";
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"]; 
    
    $sql = "SELECT id, username, password FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];

       
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $row["id"]; 
            $_SESSION["username"] = $row["username"]; 
            echo "Login successful! <a href='dashboard.php'>Go to Dashboard</a>";
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>