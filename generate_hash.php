<?php
$passwords = ["admin123", "doctor123", "patient123"];

foreach ($passwords as $pw) {
    echo $pw . " → " . password_hash($pw, PASSWORD_DEFAULT) . "<br>";
}
