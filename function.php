<?php
date_default_timezone_set("ASIA/BANGKOK");
function get_date_now()
{
  return date("Y-m-d H:i:s");
};

function number_random($count)
{

  $n = '';
  for ($i = 0; $i < $count; $i++) {
    $r = rand(0, 9);
    $n .= "$r";
  }

  return $n;
}

function char_random($count)
{

  $char = '';
  for ($i = 0; $i < $count; $i++) {
    $n =  rand(0, 25);
    $r = range('A', 'Z');
    $c = $r[$n];
    $char .= "$c";
  }

  return $char;
}
