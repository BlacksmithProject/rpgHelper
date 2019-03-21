#!/usr/bin/env bash
set -e

mv /vagrant/.gitconfig ~/.gitconfig
mv /vagrant/.gitignore_global ~/.gitignore_global
cp /vagrant/tmp/* ~/.ssh/
rm -rf /vagrant/tmp
git config --global core.excludesfile ~/.gitignore_global

cd /vagrant && make install