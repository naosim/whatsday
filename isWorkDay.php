<?php
include_once 'src/infra/WhatsDayApiCommon.php';

function toMap(WhatsDay $whatsDay) {
  return ["isWorkDay" => $whatsDay->isWorkDay()];
}
getWhatsDay("toMap");
