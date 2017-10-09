<?php

function view($view, $data = []) {
  extract($data);
  ob_start();
  include BASE_PATH . "/views/$view.php";
  return ob_get_clean();
}
