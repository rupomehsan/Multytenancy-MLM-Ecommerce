#!/bin/bash
set -e
if [ -f config/services.php ]; then
  sed -E -i "s/'client_id' => '[^']+'/'client_id' => env('GOOGLE_CLIENT_ID')/" config/services.php || true
  sed -E -i "s/'client_secret' => '[^']+'/'client_secret' => env('GOOGLE_CLIENT_SECRET')/" config/services.php || true
fi
