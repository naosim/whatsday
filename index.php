<?php
include_once 'src/infra/WhatsDayApiCommon.php';
function toMap(WhatsDay $whatsDay) {
  return $whatsDay->toMap();
}
getWhatsDay("toMap");
