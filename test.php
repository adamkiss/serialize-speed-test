#!/usr/local/bin/php

<?php
  $function = $argv[1];
  $times = count($argv) > 2 ? $argv[2] : null;

  switch ($function) {
    case 'prepare':
      rmdir('./source-loops/');
      mkdir('./source-loops/');
      $json_source = readfile('./source/data.json');
      $yaml_source = readfile('./source/data.yaml');
      break;
    default:
      echo <<<HELP
Serializer method speed test v1:
Usage: ./test.php {method} {count}
       {method} - 'json', 'pw-json', 'spyc', 'symf', 'radham'
       {count}  - number of input files to parse

       {method} - help methods: 'prepare'
HELP;
      break;
  }