#! /bin/bash

echo "Waiting for mysql to start"

while ! mysqladmin ping -h"localhost" --silent; do
    echo "mysql is unavailable - sleeping"
    sleep 1
done

echo "mysql is up - executing command"
