#!/bin/bash

echo "Generating build directory..."
rm -rf "$(pwd)/release"
mkdir -p "$(pwd)/release"

echo "Building admin-shell..."
./vendor/bin/yaycommerce-prerelease || exit 1

echo "Syncing files..."
rsync -rc --exclude-from="$(pwd)/.distignore" "$(pwd)/" "$(pwd)/release/filester" --delete --delete-excluded

echo "Generating production autoloader..."
cp composer.json composer.lock "$(pwd)/release/filester/"
(cd "$(pwd)/release/filester" && composer dump-autoload --no-dev --classmap-authoritative --no-interaction && rm composer.json composer.lock) || exit 1

echo "Generating zip file..."
cd "$(pwd)/release"
zip -q -r "filester.zip" "filester/"
rm -rf filester
echo "Generated release file"

echo "Build successful"