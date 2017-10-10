<?php

require 'helpers.php';

use App\Router;
use App\TvGuide;

// Hardcode some nice and safe channels :)
$channels = [
  'tv6.se',
  'kunskapskanalen.svt.se',
  'cartoonnetwork.se',
];

$today = date('Y-m-d');

$app = new Router;

$app->get('/', function() {
  return view('home', [
    'today' => date('Y-m-d'),
    'channels' => (new TvGuide)->channels(),
  ]);
});

$app->get('/xml', function() use ($today) {
  return xml((new TvGuide)->inXml($today, $_GET['channels'] ?? []));
});

$app->get('/xhtml', function() use ($today) {
  return (new TvGuide)->inXhtml($today, $_GET['channels'] ?? []);
});

$app->get('/pdf', function() use ($today) {
  return (new TvGuide)->asPdf($today, $_GET['channels'] ?? []);
});

$app->run();
