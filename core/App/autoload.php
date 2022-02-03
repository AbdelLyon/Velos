<?php

/**
 * Gère le chargement automatique des classes lorsqu'on les demande !
 */

spl_autoload_register(function ($className) {
   $className = str_replace('\\', '/', $className);
   require_once "core/$className.php";
});
