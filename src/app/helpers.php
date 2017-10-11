<?php

/**
 * Parse a view with data and return its content.
 */
function view($view, $data = []) {
  extract($data);
  ob_start();
  include SRC_PATH . "/views/$view.php";
  return ob_get_clean();
}

/**
 * Return an XML response with an appropriate header.
 */
function xml($data) {
  header('Content-Type: text/xml');

  return $data;
}

/**
 * Return a PDF response with the appropriate headers.
 */
function pdf($data) {
  header('Content-Type: application/pdf');
  header('Content-Disposition: inline; filename="TV-guide.pdf"');
  header('Content-Transfer-Encoding: binary');
  header('Content-Length: ' . strlen($data));
  header('Accept-Ranges: bytes');

  return $data;
}

/**
 * Cache the result of the callback by the given key
 * for a certain period of time. If an item already
 * exists in the cache, it will be returned.
 */
function cache($key, $minutes, $callback) {
  $file = SRC_PATH . '/cache/' . md5($key) . '.cache';

  if (file_exists($file) && time() < filemtime($file) + $minutes * 60) {
    return unserialize(file_get_contents($file));
  }

  $data = $callback();

  file_put_contents($file, serialize($data));

  return $data;
}
