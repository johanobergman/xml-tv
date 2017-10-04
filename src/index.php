<?php

$proc = new Saxon\SaxonProcessor(false);

$xslt = $proc->newXsltProcessor();

echo 'Saxon XSLT: OK';

echo '<br>';

echo 'Apache FOP: ' . file_get_contents('http://fop:6000');

phpinfo();