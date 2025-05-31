#!/bin/bash

# Description: Delete all files starting with "._" recursively from the current directory

echo "Searching for files starting with '._'..."

# Find and delete files
find . -type f -name '._*' -print -exec rm -v {} \;

echo "Deletion completed."

