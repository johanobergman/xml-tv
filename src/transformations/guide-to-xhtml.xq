declare namespace saxon="http://saxon.sf.net/";
declare option saxon:output "method=xhtml";
declare option saxon:output "omit-xml-declaration=no";
declare option saxon:output "doctype-public=-//W3C//DTD XHTML 1.0 Strict//EN";
declare option saxon:output "doctype-system=http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd";
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="sv" lang="sv">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Tv-guiden</title>
  <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="https://unpkg.com/minireset.css@0.0.3/minireset.min.css" />
  <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
  <div class="py-8 bg-1">
    <h1 class="centered color-white text-9 text-shadow-2">TV-guiden</h1>
  </div>
  <ul>
    {
      for $channel in //*:channel
      return <li>{data($channel//*:name)}</li>
    }
  </ul>
</body>
</html>
