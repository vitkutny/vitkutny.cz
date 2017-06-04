#!/usr/bin/env bash

grep -q "cd /vagrant" ~/.profile 2> "/dev/null" || echo "cd /vagrant" >> ~/.profile

