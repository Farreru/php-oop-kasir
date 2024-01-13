<?php
if (isset($_COOKIE['_users'])) {
    $usersCookieValue = json_decode($_COOKIE['_users'], true);
    if (isset($usersCookieValue['id'])) {
        $_SESSION['user'] = $usersCookieValue;
    }
} else {
}
