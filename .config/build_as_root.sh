#!/bin/bash

# Install dependencies
apt update
apt install -y ca-certificates curl gnupg

# Install Supervisor
apt update
apt install -y supervisor

# Setup Supervisor
cp -f /app/.config/supervisor-lando.conf /etc/supervisor/conf.d/supervisor.conf
