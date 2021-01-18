#!/bin/bash

if [ -z "$GITHUB_USERNAME" ] ; then
  echo "we need a github username in order to proceed";
  exit 1;
fi
if [ -z "$GITHUB_TOKEN" ] ; then
  echo "we need a github token in order to proceed";
  exit 1;
fi
if [ -z "$CI_REPOSITORY_URL" ] ; then
  echo "we need a repository url to proceed";
  exit 1;
fi

# force a full clone, instead of expecting a non shallow cloned repository
git clone $CI_REPOSITORY_URL /tmp/repository
cd /tmp/repository

# Remove the default origin/HEAD -> origin/master ref
# as github shows this as new branch
git remote set-head origin -d

git push --prune https://${GITHUB_USERNAME}:${GITHUB_TOKEN}@github.com/transip/transip-api-php.git +refs/remotes/origin/*:refs/heads/* +refs/tags/*:refs/tags/*
