<?php

use App\Factory\EntityManagerFactory;

require_once 'vendor/autoload.php';

$container = require 'container.php';

$entityManager = (new EntityManagerFactory)($container);
