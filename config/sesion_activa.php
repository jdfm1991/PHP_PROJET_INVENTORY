<?php
if ($_SERVER['REQUEST_URI'] != URI) {
    if ($_SESSION) { 
      echo '<input type="hidden" id="usuario" value=' . $_SESSION['id'] . '>';
    } else {
      header("Location: ../");
      die();
    } 
  } else {
    if ($_SESSION) {  
      echo '<input type="hidden" id="usuario" value=' . $_SESSION['id'] . '>';
    }
  }