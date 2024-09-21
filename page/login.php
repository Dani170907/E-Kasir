    <style>
    body {
        padding-top: 40px;
        padding-bottom: 40px;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }
    .form-signin .checkbox {
        font-weight: normal;
    }
    .form-signin .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
                box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>
<form class="form-signin" method="post">
    <h2 class="form-signin-heading">Silahkan Login</h2>
    <label for="inputEmail" class="sr-only">Username</label>
    <input type="text" name="username" id="inputEmail" class="form-control" placeholder="Username" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>

    <button name="login" class="btn btn-lg btn-primary btn-block" type="submit">Masuk</button>
</form>

<?php
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Enkripsi password input menggunakan md5
    $password_input = md5(trim($password));

    // Query untuk mendapatkan data user berdasarkan username
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $query = mysqli_query($connection, $sql);
    $check = mysqli_num_rows($query);

    // Debug jumlah data yang ditemukan
    // echo "Jumlah data ditemukan: " . $check . "<br>";

    if ($check > 0) {
        $data = mysqli_fetch_array($query);

        // Ambil password yang sudah di-enkripsi md5 dari database
        $pass_db = trim($data['password']);

        // Debug panjang password dari input dan dari database
        // echo "Panjang password input: " . strlen($password_input) . "<br>";
        // echo "Panjang password dari database: " . strlen($pass_db) . "<br>";

        // Bandingkan password input yang sudah di-enkripsi dengan password di database
        if ($password_input === $pass_db) {
            echo "Sama";
        } else {
            // echo "Input password (md5): " . $password_input . "<br>";
            // echo "Password database: " . $pass_db . "<br>";
            ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Gagal!</strong> Password Anda salah
            </div>
            <?php
        }
    } else {
        ?>
        <div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Gagal!</strong> Username tidak ditemukan
        </div>
        <?php
    } 
}
