<?php
$base = new PDO('mysql:host=localhost;dbname=tp2', 'root', 'secret');
$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
