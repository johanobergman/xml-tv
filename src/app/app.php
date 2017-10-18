<?php

require 'helpers.php';

use App\Router;
use App\TvGuide;

$date = $_GET['date'] ?? date('Y-m-d');

$app = new Router;

$app->get('/', function() use ($date) {
  return view('home', [
    'date' => $date,
    'channels' => (new TvGuide)->channels(),
  ]);
});

$app->get('/xml', function() use ($date) {
  return xml((new TvGuide)->inXml($date, $_GET['channels'] ?? []));
});

$app->get('/xhtml', function() use ($date) {
  return (new TvGuide)->inXhtml($date, $_GET['channels'] ?? []);
});

$app->get('/TV-guide.pdf', function() use ($date) {
  return pdf((new TvGuide)->asPdf($date, $_GET['channels'] ?? []));
});

$app->run();
