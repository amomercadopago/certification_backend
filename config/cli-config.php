<?php

use Doctrine\ORM\Tools\Console\ConsoleRunner;

/** @var $entityManager */
require_once 'bootstrap.php';

return ConsoleRunner::createHelperSet($entityManager);