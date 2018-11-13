#!/usr/bin/env bash

echo $1;

while [ 0 == 0 ]
do
    php index.php "$1"
    notify-send "issue-resolver" "Finished executing a stack of issues."
done
