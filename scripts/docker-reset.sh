#!/usr/bin/env bash
set -euo pipefail

# Remove containers antigos fixos (container_name) para evitar conflito
for c in hydrax_nginx hydrax_app hydrax_redis hydrax_mysql; do
  if docker ps -a --format '{{.Names}}' | grep -qx "$c"; then
    docker rm -f "$c" >/dev/null
  fi
done

# Sobe novamente com a configuração do monorepo
./scripts/docker-up.sh
