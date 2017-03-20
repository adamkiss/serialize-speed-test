#!/usr/local/bin/php

<?php
  require './vendor/autoload.php';

  $function = $argv[1];
  $times = count($argv) > 2 ? (int) $argv[2] : null;

  const JSON = 'json';
  const YAML = 'yaml';
  const ENT  = "\n";

  // source: http://php.net/manual/en/function.memory-get-usage.php#96280
  function convert($size)
  {
    $unit=array('b','kb','mb','gb','tb','pb');
    return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
  }
  function memory_used($ru = true){
    echo ENT.'Memory used: '.convert(memory_get_usage($ru)).ENT;
  }

  // source: http://www.php.net/manual/en/function.rmdir.php#98622
 function rrmdir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }

  // source processwire@3.0.42:/wire/core/Functions.php
  function wireDecodeJSON($json) {
    if(empty($json) || $json == '[]') return array();
    return json_decode($json, true);
  }

  function datafile($fmt, $i){
    return "./source-loops/data-{$i}.{$fmt}";
  }
  function readdatafile($fmt, $i){
    return file_get_contents(datafile($fmt, $i));
  }

  $data = [];
  switch ($function) {
    case 'pw-json':
      // require './vendor/processwire/processwire/wire/core/Functions.php';
      for ($i=0; $i < $times; $i++) {
          $file = readdatafile(JSON, $i);
          $data[$i] = wireDecodeJSON($file);
      }
      echo 'count: '.count($data).ENT.'test item: '.$data[0]['longarr'][2]['item'].ENT;
      memory_used();
      break;
    case 'json':
      for ($i=0; $i < $times; $i++) {
          $file = readdatafile(JSON, $i);
          $data[$i] = json_decode($file);
      }
      echo 'count: '.count($data).ENT.'test item: '.$data[0]->longarr[2]->item.ENT;
      memory_used();
      break;
    case 'prepare':
      rrmdir('./source-loops/');
      mkdir('./source-loops/');
      $json_source = file_get_contents('./source/data.json');
      $yaml_source = file_get_contents('./source/data.yaml');
      for ($i=0; $i < 5000; $i++) {
        file_put_contents("./source-loops/data-{$i}.json", $json_source);
        file_put_contents("./source-loops/data-{$i}.yaml", $yaml_source);
      }
      echo "Prepared 5000 JSON and Yaml files.".ENT;
      memory_used();
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