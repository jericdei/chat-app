#!/bin/bash

service supervisor start
supervisorctl start laravel-queue:*
supervisorctl start laravel-reverb:*
