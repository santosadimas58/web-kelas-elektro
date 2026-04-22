#!/bin/bash

until php artisan migrate --force 2>/dev/null; do
  echo "Waiting for MySQL..."
  sleep 3
done

USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null)
if [ "$USER_COUNT" = "0" ]; then
  php artisan db:seed --force
fi

php artisan serve --host=0.0.0.0 --port=8000
