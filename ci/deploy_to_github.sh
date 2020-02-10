#!/bin/bash

if [ -z "$GITHUB_TOKEN" ] ; then
  echo "we need a github token in order to proceed";
  exit 1;
fi

git push --prune https://${GITHUB_USERNAME}:${GITHUB_TOKEN}@github.com/transip/transip-rest-api-php.git +refs/remotes/origin/*:refs/heads/* +refs/tags/*:refs/tags/*
