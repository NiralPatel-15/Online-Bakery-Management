#!/bin/bash

# MIT License Header
read -r -d '' LICENSE_HEADER << EOM
/*
 * This file is part of the Online Bakery Management System.
 * 
 * Copyright (c) 2025 Niral Patel
 * 
 * This project is licensed under the MIT License.
 * See the LICENSE file for more details.
 */
EOM

# File extensions to include
EXTENSIONS=("php" "html" "js" "css")

# Loop through each file with matching extension
for EXT in "${EXTENSIONS[@]}"; do
    for FILE in $(find . -type f -name "*.$EXT"); do
        echo "Adding license to $FILE"
        # Backup file just in case
        cp "$FILE" "$FILE.bak"
        # Prepend license header
        (echo "$LICENSE_HEADER"; echo ""; cat "$FILE") > temp && mv temp "$FILE"
    done
done

echo "✅ License header added to all relevant files."
