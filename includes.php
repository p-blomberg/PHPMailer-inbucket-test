<?php
require __DIR__."/vendor/autoload.php";

spl_autoload_register(function ($class) {
  $path = __DIR__."/models/".$class.".php";
  if(file_exists($path)) {
    require $path;
  } else {
    throw new Exception("Failed to load class: $class");
  }
});
