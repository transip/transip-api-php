#!/bin/bash

set -e

TAG_VERSION="$1"

# Ensure tag version has been provided
if [ -z "$TAG_VERSION" ] ; then
  echo "we need a version in order to proceed";
  exit 1;
fi

description="$(git tag -l -n999 --format='%(contents)' $TAG_VERSION)"

# Ensure tag message is not empty
if echo $description | grep "Merge"; then
  echo "the tag message is empty, you must enter a tag message before deployment";
  exit 1;
fi
