<?php

session_start();

include('server/connection.php');

if(isset($_SESSION['logged_in'])){
    header('location:account.php');
    exit;
}





if (isset($_POST['login_btn'])) {

    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email=? AND user_password=? LIMIT 1");
    $stmt->bind_param('ss', $email, $password);

    if ($stmt->execute()) {
        $stmt->store_result(); // Store the result to check num_rows
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $user_name, $user_email, $user_password);
            $stmt->fetch();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_email'] = $user_email;
            $_SESSION['logged_in'] = true;

            header('location: account.php?message=Login Successful'); // Redirect to account details
            exit(); // Ensure no further code is executed after redirection
        } else {
            header('location: login.php?error=Could not verify');
            exit();
        }
    } else {
        // Error
        header('location: login.php?error=Something went wrong');
        exit();
    }

    $stmt->close();
}

?>

<?php include('assets/layouts/header.php'); ?>

      <section class="my-5 py-5">
        <div class="container text-center mt-3 pt-3">
            <h2 class="font-weight-bold">Login</h2>
            <hr class="mx-auto">
        </div>
        <div class="mx-auto container">
            <form id="login-form" method="POST" action ="login.php">
                <p style="color:red" class="text-center"><?php if(isset($_GET['error'])){echo $_GET['error'];}?></p>
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" class="form-control" id="login-email" name="email" placeholder="Email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn" id="login-btn" name="login_btn" value="Login">
                </div>

                <div class="form-group">
                    <a id="register-url" href="register.php" class="btn">Don't have an Account? Register</a>
                </div>


            </form>
        </div>
      </section>


      <?php include('assets/layouts/footer.php'); ?>