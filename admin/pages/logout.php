<?php

namespace App; 
require $_SERVER['DOCUMENT_ROOT'] . '/loader.php'; 

// Unset все переменные сессии.
session_unset();
// Наконец, разрушить сессию.
session_destroy();

redirect('/admin/');