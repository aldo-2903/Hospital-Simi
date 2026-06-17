<?php

echo "PDO existe: ";

var_dump(class_exists('PDO'));

echo "<br>";

print_r(PDO::getAvailableDrivers());
