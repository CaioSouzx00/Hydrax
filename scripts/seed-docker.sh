#!/usr/bin/env bash
set -euo pipefail

docker compose -f infra/docker/docker-compose.yml exec app php artisan db:seed "$@"
