<?php

// Valid.
for ($i = 0; $i < 10; $i++) {
}

// Invalid.
for ( $i = 0; $i < 10; $i++ ) {
}

for ($i = 0;  $i < 10;  $i++) {
}

for ($i = 0 ; $i < 10 ; $i++) {
}

for ($i = 0;$i < 10;$i++) {
}

// The works.
for ( $i = 0 ;  $i < 10 ;  $i++ ) {
}

for ($i = 0; $i < 10;) {
}

for ($i = 0; $i < 10; ) {
}

for ($i = 0; ; $i++) {
}
for ($i = 0;; $i++) {
}

// @codingStandardsChangeSetting Snake.ControlStructures.ForLoopDeclaration requiredSpacesAfterOpen 1
// @codingStandardsChangeSetting Snake.ControlStructures.ForLoopDeclaration requiredSpacesBeforeClose 1
for ($i = 0; $i < 10; $i++) {}
for ( $i = 0; $i < 10; $i++ ) {}
for (  $i = 0; $i < 10; $i++  ) {}
// @codingStandardsChangeSetting Snake.ControlStructures.ForLoopDeclaration requiredSpacesAfterOpen 0
// @codingStandardsChangeSetting Snake.ControlStructures.ForLoopDeclaration requiredSpacesBeforeClose 0
