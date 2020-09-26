<?php

function redirect( $val ) {
    $r = route($val);
    header( "Location: {$r}" );
}

function folder() {
  $url = "public/img/";
  return $url;
}
