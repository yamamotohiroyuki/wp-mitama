<?php
$update_json_path = 'http://example.com/path/to/theme.json';
$thema_name = 'mitama';
require get_template_directory() . '/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
  $update_json_path, // (A)
    __FILE__,
    $thema_name // (B)
);
?>