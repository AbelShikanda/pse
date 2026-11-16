#!/bin/bash
# MySQL (MariaDB) -> PostgreSQL data migration for PrintShopEld.
# Copies DATA ONLY into a schema that Laravel has already built on PostgreSQL
# (php artisan migrate), so IDs, foreign keys and the mirror tables are all intact.
#
# Prerequisites:
#   1. PostgreSQL role + empty database created (see notes/PG-MIGRATION.txt)
#   2. php artisan migrate has been run against the PostgreSQL database
#   3. pgloader installed:  sudo apt-get install pgloader
#   4. A fresh mysqldump backup exists
#
# Usage:
#   MYSQL_PASSWORD='...' PG_PASSWORD='...' MYSQL_HOST=127.0.0.1 PG_HOST=127.0.0.1 \
#     PG_PORT=5432 PG_DATABASE=printshop ./scripts/pg_migrate.sh
#
# Optional overrides:
#   MYSQL_DATABASE=printshop  (default: printshop)
#   MYSQL_USER=root           (default: root)
#   MYSQL_PORT=3306           (default: 3306)
#   PG_USER=printshop         (default: printshop)
#
# Triggers on the target are dropped before the copy (otherwise the audit
# mirrors would double-record every imported row) and recreated afterwards.

set -euo pipefail

: "${MYSQL_HOST:=127.0.0.1}"
: "${MYSQL_PORT:=3306}"
: "${MYSQL_DATABASE:=printshop}"
: "${MYSQL_USER:=root}"
: "${PG_HOST:=127.0.0.1}"
: "${PG_PORT:=5432}"
: "${PG_DATABASE:=printshop}"
: "${PG_USER:=printshop}"
: "${MYSQL_PASSWORD:?set MYSQL_PASSWORD in the environment}"
: "${PG_PASSWORD:?set PG_PASSWORD in the environment}"

DROP_TRIGGERS=$(cat <<'SQL'
DROP TRIGGER IF EXISTS update_product_price_on_price_change ON prices;
DROP TRIGGER IF EXISTS update_product_price_on_type_change ON products;
DROP TRIGGER IF EXISTS trg_failed_jobs_mirror_delete ON failed_jobs;
DROP TRIGGER IF EXISTS trg_failed_jobs_mirror_update ON failed_jobs;
DROP TRIGGER IF EXISTS trg_failed_jobs_mirror_insert ON failed_jobs;
DROP TRIGGER IF EXISTS trg_personal_access_tokens_mirror_delete ON personal_access_tokens;
DROP TRIGGER IF EXISTS trg_personal_access_tokens_mirror_update ON personal_access_tokens;
DROP TRIGGER IF EXISTS trg_personal_access_tokens_mirror_insert ON personal_access_tokens;
DROP TRIGGER IF EXISTS trg_password_resets_mirror_delete ON password_resets;
DROP TRIGGER IF EXISTS trg_password_resets_mirror_update ON password_resets;
DROP TRIGGER IF EXISTS trg_password_resets_mirror_insert ON password_resets;
DROP TRIGGER IF EXISTS trg_wish_lists_mirror_delete ON wish_lists;
DROP TRIGGER IF EXISTS trg_wish_lists_mirror_update ON wish_lists;
DROP TRIGGER IF EXISTS trg_wish_lists_mirror_insert ON wish_lists;
DROP TRIGGER IF EXISTS trg_blog_mirror_delete ON blog_images;
DROP TRIGGER IF EXISTS trg_blog_mirror_update ON blog_images;
DROP TRIGGER IF EXISTS trg_blog_mirror_insert ON blog_images;
DROP TRIGGER IF EXISTS trg_product_mirror_delete ON product_images;
DROP TRIGGER IF EXISTS trg_product_mirror_update ON product_images;
DROP TRIGGER IF EXISTS trg_product_mirror_insert ON product_images;
DROP TRIGGER IF EXISTS trg_order_mirror_delete ON order__items;
DROP TRIGGER IF EXISTS trg_order_mirror_delete ON orders;
DROP TRIGGER IF EXISTS trg_order_mirror_update_items ON order__items;
DROP TRIGGER IF EXISTS trg_order_mirror_update ON orders;
DROP TRIGGER IF EXISTS trg_order_mirror_insert ON order__items;
DROP TRIGGER IF EXISTS trg_order_mirror_insert ON orders;
DROP TRIGGER IF EXISTS trg_user_mirror_delete ON users;
DROP TRIGGER IF EXISTS trg_user_mirror_update ON users;
DROP TRIGGER IF EXISTS trg_user_mirror_insert ON users;
SQL
)

TMPDIR_LOADER="$(mktemp -d)"
trap 'rm -rf "$TMPDIR_LOADER"' EXIT

{
    echo 'LOAD DATABASE'
    echo "     FROM mysql://${MYSQL_USER}:${MYSQL_PASSWORD}@${MYSQL_HOST}:${MYSQL_PORT}/${MYSQL_DATABASE}"
    echo "     INTO postgresql://${PG_USER}:${PG_PASSWORD}@${PG_HOST}:${PG_PORT}/${PG_DATABASE}"
    echo ''
    echo ' WITH data only,'
    echo '      truncate,'
    echo '      reset sequences,'
    echo '      batch rows = 1000,'
    echo '      batch size = 50MB,'
    echo '      workers = 4,'
    echo '      concurrency = 4'
    echo ''
    echo " SET client_encoding TO 'UTF8',"
    echo "     search_path TO 'public',"
    echo "     timezone TO 'UTC'"
    echo ''
    echo ' BEFORE LOAD DO'
    printf '     $$ %s\n' "$DROP_TRIGGERS"
    echo '     $$;'
    echo ''
} > "$TMPDIR_LOADER/printshop.load"

pgloader "$TMPDIR_LOADER/printshop.load"

echo ''
echo "Recreating triggers..."
PGPASSWORD="$PG_PASSWORD" psql -h "$PG_HOST" -p "$PG_PORT" -U "$PG_USER" -d "$PG_DATABASE" \
    -v ON_ERROR_STOP=1 -f database/postgres/mirror_triggers.sql
echo "Done. Verify with:  MYSQL_PASSWORD=... PG_PASSWORD=... php scripts/verify_counts.php"
