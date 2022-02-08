<?php

$datas = [
   ["name" => "abdel",   "age" => 38],
   ["name" => "rub",   "age" => 28],
   ["name" => "marie",   "age" => 18]
];

\header('Access-Control-Allow-Origin: *');
echo \json_encode($datas);
