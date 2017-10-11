<?php

namespace App;

use DOMXPath;
use DOMDocument;

class TvGuide {

  protected $xml;

  public function __construct($xml = null)
  {
    $this->xml = $xml ?: new XmlProcessor;
  }

  /**
   * Get a list of all XMLTV channels.
   */
  public function channels()
  {
    return cache('xmltv.index', 60 * 24, function() {
      // Load the channel index from xmltv.se.
      $document = new DOMDocument;
      $document->loadHTMLFile('http://xmltv.xmltv.se/00index.html');

      // Fetch the channel names.
      $xpath = new DOMXPath($document);
      $nodes = $xpath->query('//tbody//th');

      $channels = [];
      foreach ($nodes as $node) {
        $channels[] = $node->textContent;
      }

      return $channels;
    });
  }

  /**
   * Get a TV guide for a given date in XML format.
   */
  public function inXml($date, $channels)
  {
    // We can't cache channels individually since they are loaded in XSLT,
    // so let's cache them in groups instead. A custom XSLT resolver would
    // be ideal, but there's very little documentation on Saxon's PHP implementation.
    return cache(implode(',', $channels), 60 * 24, function() use ($date, $channels) {
      // Calculate the urls for the given channels.
      $channels = array_map(function($channel) use ($date) {
        return "http://xmltv.xmltv.se/{$channel}_$date.xml.gz";
      }, $channels);

      // Merge and process the channels using XSLT.
      return $this->xml->xslt(
        view('channels.xml', compact('channels')),
        file_get_contents(SRC_PATH . '/transformations/combine-channels.xsl')
      );
    });
  }

  /**
   * Get a TV guide for a given date in XHTML format.
   */
  public function inXhtml($date, $channels)
  {
    $base = $this->inXml($date, $channels);

    return $this->xml->xQuery(
      $base,
      file_get_contents(SRC_PATH . '/transformations/guide-to-xhtml.xq')
    );
  }

  /**
   * Get a TV guide for a given date in PDF format.
   */
  public function asPdf($date, $channels)
  {
    $base = $this->inXml($date, $channels);

    $fo = $this->xml->xslt(
      $base,
      file_get_contents(SRC_PATH . '/transformations/guide-to-fo.xsl')
    );

    return $this->post('http://fop:6000', compact('fo'))['result'];
  }

  /**
   * Send a JSON POST request.
   */
  protected function post($url, $data)
  {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $result = curl_exec($ch);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    return compact('result', 'status');
  }

}
