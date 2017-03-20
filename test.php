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
      for ($i=0; $i < 5000; $i++) {
        file_put_contents("./source-loops/data-{$i}.json", $json_source);
        file_put_contents("./source-loops/data-{$i}.yaml", $json_source);
      }
      echo "Prepared 5000 JSON and Yaml files.";
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