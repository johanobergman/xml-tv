<?php

require 'helpers.php';

use App\Router;
use App\TvGuide;

$today = date('Y-m-d');

$app = new Router;

$app->get('/', function() use ($today) {
  return view('home', [
    'today' => $today,
    'channels' => (new TvGuide)->channels(),
  ]);
});

$app->get('/xml', function() use ($today) {
  return xml((new TvGuide)->inXml($today, $_GET['channels'] ?? []));
});

$app->get('/xhtml', function() use ($today) {
  return (new TvGuide)->inXhtml($today, $_GET['channels'] ?? []);
});

$app->get('/TV-guide.pdf', function() use ($today) {
  return pdf((new TvGuide)->asPdf($today, $_GET['channels'] ?? []));
});

$app->run();
