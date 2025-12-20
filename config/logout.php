<?php
session_name('PROJECT_INVENTARY');
session_start();
session_destroy();
header('Location: ../app');


