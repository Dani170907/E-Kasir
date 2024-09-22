<?php

if (isset($_SESSION['username'])) {
    $user = $_SESSION['username'];
} else {
    // Jika tidak ada session, redirect ke halaman login
    header('Location: ?p=login');
}

date_default_timezone_set('Asia/Jakarta');
function getTime() {
    $timeNow = date("H");
    
    if ($timeNow < 6) {
        return "Malam";
    } elseif ($timeNow >= 6 && $timeNow < 12) {
        return "Pagi";
    } elseif ($timeNow >= 12 && $timeNow < 15) {
        return "Siang";
    } elseif ($timeNow >= 15 && $timeNow < 18 ) {
        return "Sore";
    } else {
        return "Malam";
    }
    
}
function salam($name) {
    $currentTime = getTime();
    return "Selamat $currentTime, $name!";
}
?>

<div class="jumbotron">
    <div class="container">
        <h1><?= salam($user) ?></h1>
        <p>This is a template for a simple marketing or informational website. It includes a large callout called a jumbotron and three supporting pieces of content. Use it as a starting point to create something more unique.</p>
        <!-- <p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more &raquo;</a></p> -->
    </div>
</div>
