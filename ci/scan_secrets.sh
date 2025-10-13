#!/bin/bash

if ! which trufflehog; then
  echo "# Installing trufflehog before scanning"
  apt update -y
  apt-get install curl -y
  curl -sSfL https://raw.githubusercontent.com/trufflesecurity/trufflehog/main/scripts/install.sh | sh -s -- -b /usr/local/bin
fi

echo "# Scanning for stored secrets in repository"
trufflehog filesystem $PWD --exclude-paths .secretsignore --fail && echo "All good"
