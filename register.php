<?php 

session_start();

include('server/connection.php');


if(isset($_POST['register'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    if($password !== $confirmPassword){
        header('location: register.php?error=Password does not match!');
    } else if(strlen($password) < 6){
        header('location: register.php?error=Password should be more than 6 characters!');
    } else {
        // Check whether there is a user with this email or not 
        $stmt1 = $conn->prepare("SELECT user_email FROM users WHERE user_email=?");
        $stmt1->bind_param('s', $email);
        $stmt1->execute();
        $stmt1->store_result();

        // If there is a user already registered with this email 
        if($stmt1->num_rows > 0){
            header('location: register.php?error=User with this email already exists');
        } else {
            // Create new user 
            $stmt = $conn->prepare('INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)');
            $hashed_password = md5($password); // PHP security to hash password
            $stmt->bind_param('sss', $name, $email, $hashed_password);

            if($stmt->execute()){
                $user_id=$stmt->insert_id;
                $_SESSION['user_id']=$user_id;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['logged_in'] = true;
                header('location: account.php?register=Registration Successful.');
            } else {
                header('location: register.php?error=Could not create the account at the moment');
            }
        }
        $stmt1->close();
        $stmt->close();
    }
}
?>


<?php include('assets/layouts/header.php'); ?>


      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-3">
            <h2 class="font-weight-bold">Register</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="registration-form" method="POST" action="register.php">
<p style="color: red;"><?php if(isset($_GET["error"])){ echo $_GET['error']; } ?> </p>
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" id="register-email" name="name" placeholder="name" required>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="register-email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="confirm-Password" required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" name='register' id="register-btn" value="Register">
                </div>

                <div class="form-group">
                    <a id="login-url" class="btn" href="login.php">Do you have an Account? Login</a>
                </div>


            </form>
        </div>
      </section>


      <?php include('assets/layouts/footer.php'); ?>