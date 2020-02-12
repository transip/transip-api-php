#!/bin/bash

if [ -z "$GITHUB_USERNAME" ] ; then
  echo "we need a github username in order to proceed";
  exit 1;
fi
if [ -z "$GITHUB_TOKEN" ] ; then
  echo "we need a github token in order to proceed";
  exit 1;
fi

# Remove the default origin/HEAD -> origin/master ref
# as github shows this as new branch
git remote set-head origin -d

git push --prune https://${GITHUB_USERNAME}:${GITHUB_TOKEN}@github.com/transip/transip-rest-api-php.git +refs/remotes/origin/*:refs/heads/* +refs/tags/*:refs/tags/*
