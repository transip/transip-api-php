#!/bin/bash

if ! which trufflehog; then
  echo "# Installing trufflehog before scanning"
  pip -q install trufflehog
fi

echo "# Scanning for stored secrets in repository"
trufflehog --regex --entropy=True -x .secretsignore $CI_REPOSITORY_URL && echo "All good"
