<?php

namespace App;

use Saxon\SaxonProcessor;

class XsltProcessingFailed extends \Exception {}
class XQueryProcessingFailed extends \Exception {}

class XmlProcessor {

  /**
   * @param $saxon SaxonProcessor|string A Saxon instance or the base path.
   */
  public function __construct($saxon = null)
  {
    $this->saxon = $saxon instanceOf SaxonProcessor
      ? $saxon
      : new SaxonProcessor(false, $saxon);
  }

  /**
   * Runs an XSLT transformation and returns the result as a string.
   */
  public function xslt(string $xml, string $xslt, array $variables = []) : string
  {
    $processor = $this->saxon->newXsltProcessor();

    // Load the XSLT processor with the source XML and XSLT.
    $source = $this->saxon->parseXmlFromString($xml);
    $processor->setSourceFromXdmValue($source);

    $processor->compileFromString($xslt);

    // Pass through any variables to the XSLT file.
    // They can be read using <xsl:param name="name" required="yes" />.
    foreach ($variables as $key => $value) {
      $processor->setParameter($key, $this->saxon->createAtomicValue($value));
    }

    // Run the transformation...
    $result = $processor->transformToString();

    // ...and throw if any errors were encountered.
    $this->throwOnError($processor, XsltProcessingFailed::class);

    return $result;
  }

  /**
   * Runs an XQuery transformation and returns the result as a string.
   */
  public function xQuery(string $xml, string $query, array $variables = []) : string
  {
    $processor = $this->saxon->newXQueryProcessor();

    // Load the XQuery processor with the source XML and XQuery.
    $source = $this->saxon->parseXmlFromString($xml);
    $processor->setContextItem($source);

    $processor->setQueryContent($query);

    // Pass through any variables to the XSLT file.
    // They can be read using <xsl:param name="name" required="yes" />.
    foreach ($variables as $key => $value) {
      $processor->setParameter($key, $this->saxon->createAtomicValue($value));
    }

    // Saxon doesn't want to include doctypes when transforming
    // to string, so we'll transform it to a temporary file
    // instead, and then return its contents.
    $fileName = tempnam(sys_get_temp_dir(), 'xml-tv');

    // Run the transformation...
    $processor->runQueryToFile($fileName);
    $result = file_get_contents($fileName);
    // $result = $processor->runQueryToString();

    unlink($fileName);

    // ...and throw if any errors were encountered.
    $this->throwOnError($processor, XQueryProcessingFailed::class);

    return $result;
  }

  /**
   * Throw an exception if the given processor has any errors.
   */
  protected function throwOnError($processor, $exceptionClass)
  {
    $count = $processor->getExceptionCount();

    if ($count > 0) {
      for ($i = 0; $i < $count; $i++) {
        $code = $processor->getErrorCode($i);
        $message = $processor->getErrorMessage($i);

        throw new $exceptionClass("Error! Code: $code Message: $message");
      }

      $processor->exceptionClear();
    }
  }

}
