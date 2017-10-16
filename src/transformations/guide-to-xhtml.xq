declare namespace saxon="http://saxon.sf.net/";
declare variable $date external;
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
  <div class="shadow relative">
    <div class="container-1 flex">
      <a href="/" class="py-1 px-2 bg-gray-light-hover text-2">TV-guiden</a>
      <a href="/" class="py-1 px-2 bb-2-2 bg-gray-light-hover text-2 ml-auto">Idag</a>
      <a href="/" class="py-1 px-2 bg-gray-light-hover text-2">{$date}</a>
      <a href="/" class="py-1 px-2 bg-gray-light-hover text-2">Onsdag</a>
    </div>
  </div>
  <div class="bg-gray-light py-5">
    <ul class="flex justify-center align-start flex-wrap">
      {
        for $channel in //*:channel
        return <li class="bg-white shadow mx-3 flex-1 mb-3" style="flex-basis: 15em; max-width: 24em;">
          <div class="bb-2-2 shadow bg-white sticky-top flex align-center">
            <img
              style="line-height: 1.2;"
              class="width-5 height-5 rounded-2 ml-3 text-5"
              src="http://chanlogos.xmltv.se/{data($channel/*:name)}.png"
              alt="📺"
            />
            <h2 class="flex-1 px-2 py-1 bold">{data($channel/*:name)}</h2>
          </div>
          <ol class="list-none">
            {
              for $show in $channel/*:show
              return <li class="px-2 py-1">
                {data($show/*:title)}
              </li>
            }
          </ol>
        </li>
      }
    </ul>
  </div>
</body>
</html>
