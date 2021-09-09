#!/bin/bash

set -e

readonly TAG_VERSION="$1"

if [ -z "$GITHUB_TOKEN" ] ; then
  echo "we need a github token in order to proceed";
  exit 1;
fi
if [ -z "$TAG_VERSION" ] ; then
  echo "we need a version in order to proceed";
  exit 1;
fi

function convert_to_json() {
  python -c 'import json,sys;print( json.dumps(sys.stdin.read().strip()) )'
}

description="$(git tag -l -n999 --format='%(contents)' $TAG_VERSION | convert_to_json)"

json_output=$(curl -H "Authorization: token ${GITHUB_TOKEN}" \
  -H "Content-Type: application/json" \
  -X POST "https://api.github.com/repos/transip/transip-api-php/releases" \
  -d "{\"tag_name\": \"${TAG_VERSION}\", \"name\": \"${TAG_VERSION}\", \"body\": ${description}, \"draft\": false, \"prerelease\": false}")

echo $json_output
