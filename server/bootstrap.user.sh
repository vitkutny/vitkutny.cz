#!/usr/bin/env bash

grep -q "cd /vagrant" ~/.profile 2> "/dev/null" || echo "cd /vagrant" >> ~/.profile
ssh-keyscan -H "github.com" >> ~/.ssh/known_hosts
ssh-keyscan -H "vitkutny.cz" >> ~/.ssh/known_hosts

cd "/vagrant"
#dep build vagrant
