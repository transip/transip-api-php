#!/bin/bash

# give the full repository url when running in the CI pipeline
if [ ! -z "$CI_REPOSITORY_URL" ]
then
  REPOSITORY_PATH="$CI_REPOSITORY_URL"
else
  # when run local point to local git repository
  REPOSITORY_PATH="file://$(pwd)"
fi

if ! which trufflehog; then
  echo "# Installing trufflehog before scanning"
  pip -q install trufflehog
fi

echo "# Scanning for stored secrets in repository"

trufflehog --regex --entropy=True -x .secretsignore $REPOSITORY_PATH && echo "All good"
