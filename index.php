<?php

require_once __DIR__."/csv.php";

$CSV = new CSV;

$archivo = __DIR__."/workbay-chat-log.json";
$archivoCsv = __DIR__."/valores.csv";

$CSV->json_to_csv($archivo);
$CSV->save_output($archivoCsv);
$keys = [
  "date",
  "email",
  "message",
  "course_id",
  "author"
];
sort($keys);

var_dump($keys);//va a mostrar el orden de las keys;