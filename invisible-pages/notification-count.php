<?php
session_start();
if ($_SESSION["notification-count"] !== 0) {
    echo '<div class="notification-number">';
    echo $_SESSION["notification-count"];
    echo '</div>';
}