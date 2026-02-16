<?php
  $str= "my_password";
  $hashed_password = password_hash($str,PASSWORD_DEFAULT);
  echo $hashed_password;

#$str="my_pasword"
#echo md5($str)
?>