#!/bin/bash

set -e

TAG_VERSION="$1"

# Ensure tag version has been provided
if [ -z "$TAG_VERSION" ] ; then
  echo "we need a version in order to proceed";
  exit 1;
fi

description="$(git show --format=%N $TAG_VERSION | tail -n+3)"

# Ensure tag message is not empty
if [ -z "$description" ] ; then
  echo "the tag message is empty, you must enter a tag message before deployment";
  exit 1;
fi
