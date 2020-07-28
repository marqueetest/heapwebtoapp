<?php
$command = "D:/wamp/bin/jdk1.6.0_05/bin/java -jar D:/wamp/www/heaplan/java_calc/CalculatorApp.jar 0 0 0 0 0 1000 260 0 0 15 0 0 0 false 0 true false D:/wamp/www/heaplan/assets/payment_files/pay-422-3347.txt 422 18";

$command = "D:/Java/jdk1.6.0_45/bin/java -jar D:/wamp/www/heaplan/java_calc/CalculatorApp_new.jar 315000 180 3.75 20000 12 7904 5000 6.5 0 15 30 28 1 false 23000 true true D:/wamp/www/heaplan/assets/payment_files/pay-1577-3332.txt 422 18";

$command2 = "/home/heaplan/jdk1.6.0_05/bin/java -jar /home/heaplan/public_html/java_calc/CalculatorApp.jar 315000 180 3.75 20000 12 7904 5000 6.5 0 15 30 28 1 false 23000 true true payment_files/pay-1577-3332.txt 1577 2";

exec($command, $output, $return_var);

print_r($output);
var_dump( $return_var );
?>