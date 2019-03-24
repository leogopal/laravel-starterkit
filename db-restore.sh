#!/usr/bin/env bash

cp latest.dump db-dumps/latest-$(date +%Y-%m-%d).dump
rm latest.dump

echo Which app woud you like to get a Database dump from?
read appname

heroku pg:backups:capture --app $appname
heroku pg:backups:download --app $appname

echo What is your database username?
read userdbname

echo What is your database name?
read dbname

pg_restore --verbose --clean --no-acl --no-owner -h localhost -U $userdbname -d $dbname latest.dump
