<?php
$string = 'Hello'.$there.'. How are'.$you.$going."today $okay";
$string = 'Hello' . $there . '. How are' . $you . $going . "today $okay";
$string = 'Hello'.$there;
$string = 'Hello'. $there;
$string = 'Hello' .$there;

$y = '1'
   . '2'
   . '3';

echo 1 . 'test';
echo 1.1 . 'test';
echo 'test' . 1;
echo 'test' . 1.1;
echo 'test' . 1 . 'test' . 2.2 . 'test'   .   3;

// @codingStandardsChangeSetting Snake.Strings.ConcatenationSpacing spacing 1

$string = 'Hello'.$there.'. How are'.$you.$going.   "today $okay";
$string = 'Hello' . $there . '. How are' . $you . $going . "today $okay";
$string = 'Hello'.$there;
$string = 'Hello'. $there;
$string = 'Hello' .$there;

// @codingStandardsChangeSetting Snake.Strings.ConcatenationSpacing ignoreNewlines true
$y = '1'
   . '2'
   . '3';

$y = '1' .
     '2' .
     '3';

$y = '1'
. '2'
. '3';

$y = '1'
   .'2'.
    '3'
   .  '4';
