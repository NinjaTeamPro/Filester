#!/bin/bash

echo "Generating build directory..."
rm -rf "$(pwd)/release"
mkdir -p "$(pwd)/release"

echo "Syncing files..."
rsync -rc --exclude-from="$(pwd)/.distignore" "$(pwd)/" "$(pwd)/release/filester" --delete --delete-excluded

echo "Generating zip file..."
cd "$(pwd)/release"
zip -q -r "filester.zip" "filester/"
rm -rf filester
echo "Generated release file"

echo "Build successful"