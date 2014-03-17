<?php

class ClsValidacao
{
function ValidaCPF($cpf){
  $d1 = 0;
  $d2 = 0;
  
  $cpf = preg_replace("/[^0-9]/", "", $cpf);
  $ignore_list = array(
    '00000000000',
    '01234567890',
    '11111111111',
    '22222222222',
    '33333333333',
    '44444444444',
    '55555555555',
    '66666666666',
    '77777777777',
    '88888888888',
    '99999999999'
  );
  
  if(strlen($cpf) != 11 || in_array($cpf, $ignore_list)){
      return false;
  } else {
       for($i = 0; $i < 9; $i++){
        $d1 += $cpf[$i] * (10 - $i);
    }
    $r1 = $d1 % 11;
    $d1 = ($r1 > 1) ? (11 - $r1) : 0;
    for($i = 0; $i < 9; $i++) {
    $d2 += $cpf[$i] * (11 - $i);
    }
    $r2 = ($d2 + ($d1 * 2)) % 11;
    $d2 = ($r2 > 1) ? (11 - $r2) : 0;
    return (substr($cpf, -2) == $d1 . $d2) ? true : false;
  }
}

function ValidaCNPJ($str) {
    if (!preg_match('|^(\d{2,3})\.?(\d{3})\.?(\d{3})\/?(\d{4})\-?(\d{2})$|', $str, $matches))
        return false;

    array_shift($matches);

    $str = implode('', $matches);
    if (strlen($str) > 14)
        $str = substr($str, 1);

    $sum1 = 0;
    $sum2 = 0;
    $sum3 = 0;
    $calc1 = 5;
    $calc2 = 6;

    for ($i=0; $i <= 12; $i++) {
        $calc1 = $calc1 < 2 ? 9 : $calc1;
        $calc2 = $calc2 < 2 ? 9 : $calc2;

        if ($i <= 11)
            $sum1 += $str[$i] * $calc1;

        $sum2 += $str[$i] * $calc2;
        $sum3 += $str[$i];
        $calc1--;
        $calc2--;
    }

    $sum1 %= 11;
    $sum2 %= 11;

    return ($sum3 && $str[12] == ($sum1 < 2 ? 0 : 11 - $sum1) && $str[13] == ($sum2 < 2 ? 0 : 11 - $sum2)) ? $str : false;
} 
}
?>