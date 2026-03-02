#!/usr/bin/env bash
set -euo pipefail

./apps/hydrax/vendor/bin/phpunit -c apps/hydrax/phpunit.xml
