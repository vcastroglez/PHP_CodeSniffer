<?php

// Valid.
foreach ($something as $blah => $that) {
}

// Invalid.
foreach ( $something as $blah => $that ) {
}

foreach ($something   as   $blah => $that) {
}

foreach ($something as $blah   =>  $that) {
}

foreach (${something}AS$blah=>$that) {
}

// The works.
foreach (  $something   aS   $blah    =>   $that   ) {
}

// phpcs:set Snake.ControlStructures.ForEachLoopDeclaration requiredSpacesAfterOpen 1
// phpcs:set Snake.ControlStructures.ForEachLoopDeclaration requiredSpacesBeforeClose 1
foreach ($something as $blah => $that) {}
foreach ( $something as $blah => $that ) {}
foreach (  $something as $blah => $that  ) {}
// phpcs:set Snake.ControlStructures.ForEachLoopDeclaration requiredSpacesAfterOpen 0
// phpcs:set Snake.ControlStructures.ForEachLoopDeclaration requiredSpacesBeforeClose 0

foreach ([
          'foo'    => 'bar',
          'foobaz' => 'bazzy',
         ] as $key => $value) {
}
