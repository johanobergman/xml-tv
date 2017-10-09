<?php

require 'helpers.php';

$app = new App\Router;

$app->get('/', function() {
  return view('home', [
    'today' => date('Y-m-d'),
  ]);
});

$app->get('/xml', function() {
  // var_dump(file_get_contents('http://xmltv.xmltv.se/xmltv.dtd'));die;
  // var_dump(file_get_contents('http://xmltv.xmltv.se/00index.html'));die;
  // Load the index file of all TV channels.
  // $document = new DOMDocument;
  // $document->loadHTMLFile('http://xmltv.xmltv.se/00index.html');

  // // Fetch the channel names.
  // $xpath = new DOMXPath($document);
  // $nodes = $xpath->query('//tbody//th');

  // $names = [];
  // foreach ($nodes as $node) {
  //   $names[] = $node->textContent;
  // }

  // // We don't want all channels displayed at once, so let's pick some at random.
  // $channels = [];
  // foreach (array_rand($names, rand(3, 10)) as $i) {
  //   $channels[] = $names[$i];
  // }

  // Another option would be to hardcode some nice and safe channels :)
  $channels = [
    'tv6.se',
    'kunskapskanalen.svt.se',
    'cartoonnetwork.se',
  ];

  $today = date('Y-m-d');

  $channels = array_map(function($channel) use ($today) {
    return "http://xmltv.xmltv.se/{$channel}_$today.xml.gz";
  }, $channels);

  $saxon = new Saxon\SaxonProcessor(false, BASE_PATH . '/app/Transformations');
  $saxon->setConfigurationProperty('DTD_VALIDATION', false);
  $saxon->setConfigurationProperty('http://saxon.sf.net/feature/uriResolverClass', 'org.apache.xml.resolver.tools.CatalogResolver');
  // $saxon->setConfigurationProperty('SOURCE_PARSER_CLASS', 'org.apache.xml.resolver.tools.ResolvingXMLReader');
  // $xml = $saxon->parseXmlFromString('start.xml');
  $xml = $saxon->parseXmlFromString(view('channels.xml', compact('channels')));

  // header('Content-Type: text/xml');
  // return $xml->getStringValue();

  putenv('xml.catalog.files=catalog.xml');
  putenv('catalog=catalog.xml');
  $xslt = $saxon->newXsltProcessor();
  $xslt->setProperty('http://saxon.sf.net/feature/uriResolverClass', 'org.apache.xml.resolver.tools.CatalogResolver');
  $saxon->setConfigurationProperty('xml.catalog.files', 'catalog.xml');
  $saxon->setConfigurationProperty('catalogs', 'catalog.xml');
  $xslt->setProperty('xml.catalog.files', 'catalog.xml');
  $xslt->setProperty('catalogs', 'catalog.xml');
  // $xslt->setParameter()
  $xslt->setSourceFromXdmValue($xml);

  // $xslt->setSourceFromFile('start.xml');
  $xslt->compileFromFile('CombineChannels.xsl');
  // $xslt->setParameter('today', $saxon->createAtomicValue($today));

  $result = $xslt->transformToString();

  if ($result == null) {
    $errCount = $xslt->getExceptionCount();
    if ($errCount > 0 ) {
      for ($i = 0; $i < $errCount; $i++) {
        $errCode = $xslt->getErrorCode(intval($i));
        $errMessage = $xslt->getErrorMessage(intval($i));
        echo 'Expected error: Code='.$errCode.' Message='.$errMessage;
      }
      $xslt->exceptionClear();
    }
  }

  header('Content-Type: text/xml');
  return $result;
});

$app->get('/xhtml', function() {
  return 'Not here yet! ;)';
});

$app->get('/pdf', function() {
  return 'Not here yet! ;)';
});

$app->run();

// $proc = new Saxon\SaxonProcessor();

// $xslt = $proc->newXsltProcessor();

// echo 'Saxon XSLT: OK';

// echo '<br>';

// echo 'Apache FOP: ' . file_get_contents('http://fop:6000');

// phpinfo();
