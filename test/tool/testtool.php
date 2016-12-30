<?php
function isAllSuccess($ary) {
  foreach($ary as $value) {
    if(!$value) {
      return false;
    }
  }
  return true;
}

function showResult($result, $message = '') {
  if(isAllSuccess($result)) {
    echo $message . " SUCCESS\n";
  } else {
    echo $message . " ERROR\n";
    exit(1);
  }
}
