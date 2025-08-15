<?php
session_name('ICB');
session_start();
session_destroy();
header('Location: ../app');


