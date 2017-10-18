<?php

// TODO
// - flex-basis
// - max-width

require 'vendor/autoload.php';

use Mexitek\PHPColors\Color;

// Available sizes for text, margin, padding etc.
$sizes = [
  '\\.9' => '.5rem',
  '1'  => '.75rem',
  '2'  => '1rem',
  '3'  => '1.25rem',
  '4'  => '1.5rem',
  '5'  => '2rem',
  '6'  => '2.5rem',
  '7'  => '3rem',
  '8'  => '4.5rem',
  '9'  => '7rem',
  '10' => '10rem',
  '11' => '15rem',
];

$borderSizes = ['1px', '2px', '3px'];
$borderRadiuses = ['3px', '5px', '7px'];
$containerWidths = ['980px', '1200px'];

$baseColors = [
  1       => '#373f51',
  2       => '#008dd5',
  3       => '#eae7d7',
  'yes'   => '#59d27a',
  'no'    => '#ad4648',
  'gray'  => '#ececec',
  'black' => '#333',
  'white' => '#fff',
  'tomato' => '#ff7d5d',
];

// Generate darker and lighter colors, and gradients.
$colors = [];
$gradients = [];

foreach ($baseColors as $key => $color) {
  $c = new Color($color);

  $colors += [
    $key         => $color,
    "$key-dark"  => '#' . $c->darken(5),
    "$key-light" => '#' . $c->lighten(5),
  ];

  $gradient = $c->makeGradient();
  array_walk($gradient, function(&$g) { $g = "#$g"; });

  $gradients[$key] = $gradient;
}

// Media query breakpoints.
$breakpoints = [
  ''      => false,
  'p\\:'  => '(max-width: 768px)',
  'pt\\:' => '(max-width: 1007px)',
  't\\:'  => '(min-width: 769px) and (max-width: 1007px)',
  'td\\:' => '(min-width: 769px)',
  'd\\:'  => '(min-width: 1008px)',
];
?>

body, html {
  height: 100%;
}

body {
  color: <?= $colors['black-light'] ?>;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  font-family: 'Roboto', sans-serif;
}

a {
  color: inherit;
  text-decoration: none;
}

<?php foreach ($containerWidths as $key => $width) : ?>
  <?php $key++; ?>
  .container-<?= $key; ?> { max-width: <?= $width ?>; margin: 0 auto; }
<?php endforeach; ?>

<?php foreach ($breakpoints as $prefix => $breakpoint) : ?>
  <?php if ($breakpoint) : ?>@media <?= $breakpoint ?> {<?php endif; ?>
    <?php foreach ($sizes as $key => $size) : ?>
      <?php // Margins ?>
      <?php foreach (['', '-'] as $mod) : ?>
        .<?= $prefix ?>m-<?= $mod . $key ?>  { margin: <?= $mod . $size ?>; }
        .<?= $prefix ?>my-<?= $mod . $key ?> { margin-top: <?= $mod . $size ?>; margin-bottom: <?= $mod . $size ?>; }
        .<?= $prefix ?>mx-<?= $mod . $key ?> { margin-left: <?= $mod . $size ?>; margin-right: <?= $mod . $size ?>; }
        .<?= $prefix ?>mt-<?= $mod . $key ?> { margin-top: <?= $mod . $size ?>; }
        .<?= $prefix ?>mr-<?= $mod . $key ?> { margin-right: <?= $mod . $size ?>; }
        .<?= $prefix ?>mb-<?= $mod . $key ?> { margin-bottom: <?= $mod . $size ?>; }
        .<?= $prefix ?>ml-<?= $mod . $key ?> { margin-left: <?= $mod . $size ?>; }
      <?php endforeach; ?>

      <?php // Paddings ?>
      .<?= $prefix ?>p-<?= $key ?>  { padding: <?= $size ?>; }
      .<?= $prefix ?>py-<?= $key ?> { padding-top: <?= $size ?>; padding-bottom: <?= $size ?>; }
      .<?= $prefix ?>px-<?= $key ?> { padding-left: <?= $size ?>; padding-right: <?= $size ?>; }
      .<?= $prefix ?>pt-<?= $key ?> { padding-top: <?= $size ?>; }
      .<?= $prefix ?>pr-<?= $key ?> { padding-right: <?= $size ?>; }
      .<?= $prefix ?>pb-<?= $key ?> { padding-bottom: <?= $size ?>; }
      .<?= $prefix ?>pl-<?= $key ?> { padding-left: <?= $size ?>; }

      <?php // Other size-dependent utilities ?>
      .<?= $prefix ?>text-<?= $key ?> { font-size: <?= $size ?>; }
      .<?= $prefix ?>width-<?= $key ?> { width: <?= $size ?>; }
      .<?= $prefix ?>height-<?= $key ?> { height: <?= $size ?>; }
    <?php endforeach; ?>

    <?php foreach ($colors as $key => $color) : ?>
      <?php // Background and foreground colors ?>
      .<?= $prefix ?>bg-<?= $key ?> { background-color: <?= $color ?>; }
      .<?= $prefix ?>color-<?= $key ?> { color: <?= $color ?>; }
      .<?= $prefix ?>bg-<?= $key ?>-hover:hover { background-color: <?= $color ?>; }
      .<?= $prefix ?>color-<?= $key ?>-hover:hover { color: <?= $color ?>; }

      <?php // Borders ?>
      <?php foreach ($borderSizes as $i => $size) : ?>
        <?php $i++; ?>
        .<?= $prefix ?>b-<?= $i ?>-<?= $key ?> { border: <?= $size ?> solid <?= $color ?>; }
        .<?= $prefix ?>bt-<?= $i ?>-<?= $key ?> { border-top: <?= $size ?> solid <?= $color ?>; }
        .<?= $prefix ?>br-<?= $i ?>-<?= $key ?> { border-right: <?= $size ?> solid <?= $color ?>; }
        .<?= $prefix ?>bb-<?= $i ?>-<?= $key ?> { border-bottom: <?= $size ?> solid <?= $color ?>; }
        .<?= $prefix ?>bl-<?= $i ?>-<?= $key ?> { border-left: <?= $size ?> solid <?= $color ?>; }
      <?php endforeach; ?>
    <?php endforeach; ?>

    .<?= $prefix ?>b-dashed { border-style: dashed; }
    .<?= $prefix ?>b-dotted { border-style: dotted; }
    .<?= $prefix ?>b-none { border: none; }

    <?php foreach ($borderRadiuses as $key => $radius) : ?>
      <?php $key++; ?>
      .<?= $prefix ?>rounded-<?= $key ?> { border-radius: <?= $radius ?>; }
    <?php endforeach; ?>

    <?php // Gradient backgrounds ?>
    <?php foreach ($gradients as $key => $gradient) : ?>
      .<?= $prefix ?>gradient-<?= $key ?> { background: linear-gradient(<?= $gradient['dark'] ?>, <?= $gradient['light'] ?>); }
    <?php endforeach; ?>

    <?php // Flexbox ?>
    .<?= $prefix ?>flex { display: flex; }
    .<?= $prefix ?>flex-column { flex-direction: column; }
    .<?= $prefix ?>flex-wrap { flex-wrap: wrap; }
    .<?= $prefix ?>justify-center { justify-content: center; }
    .<?= $prefix ?>justify-between { justify-content: space-between; }
    .<?= $prefix ?>justify-around { justify-content: space-around; }
    .<?= $prefix ?>align-start { align-items: flex-start; }
    .<?= $prefix ?>align-center { align-items: center; }
    .<?= $prefix ?>align-stretch { align-items: stretch; }
    .<?= $prefix ?>flex-1 { flex: 1; }
    .<?= $prefix ?>order-1 { order: 1; }
    .<?= $prefix ?>order-2 { order: 2; }
    .<?= $prefix ?>order-3 { order: 3; }

    .<?= $prefix ?>m-auto { margin: auto; }
    .<?= $prefix ?>mx-auto { margin-left: auto; margin-right: auto; }
    .<?= $prefix ?>my-auto { margin-top: auto; margin-bottom: auto; }
    .<?= $prefix ?>mt-auto { margin-top: auto; }
    .<?= $prefix ?>mr-auto { margin-right: auto; }
    .<?= $prefix ?>mb-auto { margin-bottom: auto; }
    .<?= $prefix ?>ml-auto { margin-left: auto; }

    .<?= $prefix ?>sticky-top {
      position: sticky;
      top: 0;
    }
    .<?= $prefix ?>relative { position: relative; }

    .<?= $prefix ?>shadow {
      box-shadow: 0 2px 3px rgba(20, 20, 20, 0.1);
    }

    .<?= $prefix ?>round { border-radius: 50%; }

    .<?= $prefix ?>bold { font-weight: 500; }
    .<?= $prefix ?>light { font-weight: 300; }
    .<?= $prefix ?>italic { font-style: italic; }
    .<?= $prefix ?>centered { text-align: center; }
    .<?= $prefix ?>lh-1 { line-height: 1; }
    .<?= $prefix ?>text-shadow-1 { text-shadow: 2px 2px 4px rgba(20, 20, 20, 0.7); }
    .<?= $prefix ?>text-shadow-2 { text-shadow: 5px 5px 10px rgba(20, 20, 20, 0.7); }

    .<?= $prefix ?>fullheight { height: 100%; }
    .<?= $prefix ?>fullwidth { width: 100%; }
    .<?= $prefix ?>hidden { display: none; }
    .<?= $prefix ?>block { display: block; }
    .<?= $prefix ?>scroll-y { overflow-y: scroll; }
    .<?= $prefix ?>scroll-x { overflow-x: scroll; }
    .<?= $prefix ?>list-none { list-style: none; }

    .<?= $prefix ?>pointer { cursor: pointer; }
  <?php if ($breakpoint) : ?>}<?php endif; ?>
<?php endforeach; ?>
