#!/usr/bin/env bash
set -euo pipefail

# Local (sem docker)
php apps/hydrax/artisan db:seed "$@"
