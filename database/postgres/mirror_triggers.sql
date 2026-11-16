-- Mirror/audit triggers translated from the MySQL trigger seeders to PL/pgSQL.
-- Apply with: psql -U <role> -d <db> -f database/postgres/mirror_triggers.sql
-- Idempotent: drops and recreates functions and triggers.
-- Notes vs the MySQL originals:
--   * user() -> current_user
--   * order_mirrors.id is no longer populated with the orders.id value
--     (mixing explicit ids with auto-increment produced PK collisions).
--   * price sync triggers now join prices via prices.type_id instead of
--     assuming prices.id == products.type_id.


-- ============================================================
-- users -> user_mirrors
-- ============================================================

CREATE OR REPLACE FUNCTION fn_user_mirror_insert() RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM user_mirrors WHERE email = NEW.email AND change_type = 'delete') THEN
        UPDATE user_mirrors
        SET change_type = 'insert',
            changed_at  = now(),
            first_name  = NEW.first_name,
            last_name   = NEW.last_name,
            phone       = NEW.phone,
            town        = NEW.town,
            location    = NEW.location,
            password    = NEW.password,
            updated_by  = current_user,
            uuid        = NEW.uuid
        WHERE email = NEW.email AND change_type = 'delete';
    ELSE
        INSERT INTO user_mirrors (
            uuid, first_name, last_name, email, gender, phone, town, location,
            email_verified_at, password, updated_by, change_type, changed_at
        ) VALUES (
            NEW.uuid, NEW.first_name, NEW.last_name, NEW.email, NEW.gender, NEW.phone,
            NEW.town, NEW.location, NEW.email_verified_at, NEW.password,
            current_user, 'insert', now()
        );
    END IF;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_user_mirror_update() RETURNS TRIGGER AS $$
BEGIN
    UPDATE user_mirrors
    SET first_name        = NEW.first_name,
        last_name         = NEW.last_name,
        email             = NEW.email,
        gender            = NEW.gender,
        phone             = NEW.phone,
        town              = NEW.town,
        location          = NEW.location,
        email_verified_at = NEW.email_verified_at,
        password          = NEW.password,
        updated_by        = current_user,
        change_type       = 'update',
        changed_at        = now()
    WHERE uuid = NEW.uuid;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_user_mirror_delete() RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM user_mirrors WHERE email = OLD.email) THEN
        UPDATE user_mirrors
        SET change_type = 'delete',
            updated_at  = now()
        WHERE email = OLD.email;
    ELSE
        INSERT INTO user_mirrors (
            uuid, first_name, last_name, email, gender, phone, town, location,
            email_verified_at, password, updated_by, change_type, changed_at
        ) VALUES (
            OLD.uuid, OLD.first_name, OLD.last_name, OLD.email, OLD.gender, OLD.phone,
            OLD.town, OLD.location, OLD.email_verified_at, OLD.password,
            current_user, 'delete', now()
        );
    END IF;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_user_mirror_insert ON users;
CREATE TRIGGER trg_user_mirror_insert AFTER INSERT ON users
    FOR EACH ROW EXECUTE FUNCTION fn_user_mirror_insert();
DROP TRIGGER IF EXISTS trg_user_mirror_update ON users;
CREATE TRIGGER trg_user_mirror_update AFTER UPDATE ON users
    FOR EACH ROW EXECUTE FUNCTION fn_user_mirror_update();
DROP TRIGGER IF EXISTS trg_user_mirror_delete ON users;
CREATE TRIGGER trg_user_mirror_delete AFTER DELETE ON users
    FOR EACH ROW EXECUTE FUNCTION fn_user_mirror_delete();

-- ============================================================
-- orders -> order_mirrors (orders and order__items)
-- ============================================================

CREATE OR REPLACE FUNCTION fn_order_mirror_insert_order() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO order_mirrors (
        order_items_id, user_id, product_id, quantity, price, reference,
        complete, updated_by, change_type, changed_at
    ) VALUES (
        NULL, NEW.user_id, NULL, NULL, NEW.price, NEW.reference,
        NEW.complete, current_user, 'insert', now()
    );
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_order_mirror_insert_item() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO order_mirrors (
        order_id, order_items_id, user_id, product_id, quantity, price, reference,
        complete, updated_by, change_type, changed_at
    ) VALUES (
        NEW.order_id, NEW.id,
        (SELECT user_id FROM orders WHERE id = NEW.order_id),
        NEW.product_id, NEW.quantity, NULLIF(NEW.price, '')::numeric,
        (SELECT reference FROM orders WHERE id = NEW.order_id),
        (SELECT complete FROM orders WHERE id = NEW.order_id),
        current_user, 'insert', now()
    );
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_order_mirror_update() RETURNS TRIGGER AS $$
BEGIN
    UPDATE order_mirrors
    SET complete    = NEW.complete,
        updated_by  = current_user,
        change_type = 'update',
        changed_at  = now()
    WHERE order_id = NEW.id;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_order_mirror_update_items() RETURNS TRIGGER AS $$
BEGIN
    UPDATE order_mirrors
    SET quantity    = NEW.quantity,
        price       = NULLIF(NEW.price, '')::numeric,
        product_id  = NEW.product_id,
        updated_by  = current_user,
        change_type = 'update',
        changed_at  = now()
    WHERE order_items_id = NEW.id;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_order_mirror_delete_order() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO order_mirrors (
        order_items_id, user_id, product_id, quantity, price, reference,
        complete, updated_by, change_type, changed_at
    ) VALUES (
        NULL, OLD.user_id, NULL, NULL, OLD.price, OLD.reference,
        OLD.complete, current_user, 'delete', now()
    );
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_order_mirror_delete_item() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO order_mirrors (
        order_id, order_items_id, user_id, product_id, quantity, price, reference,
        complete, updated_by, change_type, changed_at
    ) VALUES (
        OLD.order_id, OLD.id,
        (SELECT user_id FROM orders WHERE id = OLD.order_id),
        OLD.product_id, OLD.quantity, NULLIF(OLD.price, '')::numeric,
        (SELECT reference FROM orders WHERE id = OLD.order_id),
        (SELECT complete FROM orders WHERE id = OLD.order_id),
        current_user, 'delete', now()
    );
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_order_mirror_insert ON orders;
CREATE TRIGGER trg_order_mirror_insert AFTER INSERT ON orders
    FOR EACH ROW EXECUTE FUNCTION fn_order_mirror_insert_order();
DROP TRIGGER IF EXISTS trg_order_mirror_insert ON order__items;
CREATE TRIGGER trg_order_mirror_insert AFTER INSERT ON order__items
    FOR EACH ROW EXECUTE FUNCTION fn_order_mirror_insert_item();
DROP TRIGGER IF EXISTS trg_order_mirror_update ON orders;
CREATE TRIGGER trg_order_mirror_update AFTER UPDATE ON orders
    FOR EACH ROW EXECUTE FUNCTION fn_order_mirror_update();
DROP TRIGGER IF EXISTS trg_order_mirror_update_items ON order__items;
CREATE TRIGGER trg_order_mirror_update_items AFTER UPDATE ON order__items
    FOR EACH ROW EXECUTE FUNCTION fn_order_mirror_update_items();
DROP TRIGGER IF EXISTS trg_order_mirror_delete ON orders;
CREATE TRIGGER trg_order_mirror_delete AFTER DELETE ON orders
    FOR EACH ROW EXECUTE FUNCTION fn_order_mirror_delete_order();
DROP TRIGGER IF EXISTS trg_order_mirror_delete ON order__items;
CREATE TRIGGER trg_order_mirror_delete AFTER DELETE ON order__items
    FOR EACH ROW EXECUTE FUNCTION fn_order_mirror_delete_item();

-- ============================================================
-- product_images -> product_mirrors
-- ============================================================

CREATE OR REPLACE FUNCTION fn_product_mirror_insert() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO product_mirrors (thumbnail, "full", products_id, updated_by, change_type, changed_at)
    VALUES (NEW.thumbnail, NEW."full", NEW.products_id, current_user, 'insert', now());
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_product_mirror_update() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO product_mirrors (thumbnail, "full", products_id, updated_by, change_type, changed_at)
    VALUES (NEW.thumbnail, NEW."full", NEW.products_id, current_user, 'update', now());
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_product_mirror_delete() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO product_mirrors (thumbnail, "full", products_id, updated_by, change_type, changed_at)
    VALUES (OLD.thumbnail, OLD."full", OLD.products_id, current_user, 'delete', now());
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_product_mirror_insert ON product_images;
CREATE TRIGGER trg_product_mirror_insert AFTER INSERT ON product_images
    FOR EACH ROW EXECUTE FUNCTION fn_product_mirror_insert();
DROP TRIGGER IF EXISTS trg_product_mirror_update ON product_images;
CREATE TRIGGER trg_product_mirror_update AFTER UPDATE ON product_images
    FOR EACH ROW EXECUTE FUNCTION fn_product_mirror_update();
DROP TRIGGER IF EXISTS trg_product_mirror_delete ON product_images;
CREATE TRIGGER trg_product_mirror_delete AFTER DELETE ON product_images
    FOR EACH ROW EXECUTE FUNCTION fn_product_mirror_delete();

-- ============================================================
-- blog_images -> blog_mirrors (MySQL table was Blog_mirrors; PG folds to lowercase)
-- ============================================================

CREATE OR REPLACE FUNCTION fn_blog_mirror_insert() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO blog_mirrors (thumbnail, "full", blogs_id, updated_by, change_type, changed_at)
    VALUES (NEW.thumbnail, NEW."full", NEW.blogs_id, current_user, 'insert', now());
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_blog_mirror_update() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO blog_mirrors (thumbnail, "full", blogs_id, updated_by, change_type, changed_at)
    VALUES (NEW.thumbnail, NEW."full", NEW.blogs_id, current_user, 'update', now());
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_blog_mirror_delete() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO blog_mirrors (thumbnail, "full", blogs_id, updated_by, change_type, changed_at)
    VALUES (OLD.thumbnail, OLD."full", OLD.blogs_id, current_user, 'delete', now());
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_blog_mirror_insert ON blog_images;
CREATE TRIGGER trg_blog_mirror_insert AFTER INSERT ON blog_images
    FOR EACH ROW EXECUTE FUNCTION fn_blog_mirror_insert();
DROP TRIGGER IF EXISTS trg_blog_mirror_update ON blog_images;
CREATE TRIGGER trg_blog_mirror_update AFTER UPDATE ON blog_images
    FOR EACH ROW EXECUTE FUNCTION fn_blog_mirror_update();
DROP TRIGGER IF EXISTS trg_blog_mirror_delete ON blog_images;
CREATE TRIGGER trg_blog_mirror_delete AFTER DELETE ON blog_images
    FOR EACH ROW EXECUTE FUNCTION fn_blog_mirror_delete();

-- ============================================================
-- wish_lists -> wish_lists_mirrors
-- ============================================================

CREATE OR REPLACE FUNCTION fn_wish_lists_mirror_insert() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO wish_lists_mirrors (user_id, product_id, updated_by, change_type, changed_at)
    VALUES (NEW.user_id, NEW.product_id, current_user, 'insert', now());
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_wish_lists_mirror_update() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO wish_lists_mirrors (user_id, product_id, updated_by, change_type, changed_at)
    VALUES (NEW.user_id, NEW.product_id, current_user, 'update', now());
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_wish_lists_mirror_delete() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO wish_lists_mirrors (user_id, product_id, updated_by, change_type, changed_at)
    VALUES (OLD.user_id, OLD.product_id, current_user, 'delete', now());
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_wish_lists_mirror_insert ON wish_lists;
CREATE TRIGGER trg_wish_lists_mirror_insert AFTER INSERT ON wish_lists
    FOR EACH ROW EXECUTE FUNCTION fn_wish_lists_mirror_insert();
DROP TRIGGER IF EXISTS trg_wish_lists_mirror_update ON wish_lists;
CREATE TRIGGER trg_wish_lists_mirror_update AFTER UPDATE ON wish_lists
    FOR EACH ROW EXECUTE FUNCTION fn_wish_lists_mirror_update();
DROP TRIGGER IF EXISTS trg_wish_lists_mirror_delete ON wish_lists;
CREATE TRIGGER trg_wish_lists_mirror_delete AFTER DELETE ON wish_lists
    FOR EACH ROW EXECUTE FUNCTION fn_wish_lists_mirror_delete();

-- ============================================================
-- password_resets -> password_resets_mirrors
-- ============================================================

CREATE OR REPLACE FUNCTION fn_password_resets_mirror_insert() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO password_resets_mirrors (email, token, updated_by, change_type, changed_at)
    VALUES (NEW.email, NEW.token, current_user, 'insert', now())
    ON CONFLICT (email) DO UPDATE
        SET token       = EXCLUDED.token,
            updated_by  = current_user,
            change_type = 'insert',
            changed_at  = now();
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_password_resets_mirror_update() RETURNS TRIGGER AS $$
BEGIN
    UPDATE password_resets_mirrors
    SET token       = NEW.token,
        updated_by  = current_user,
        change_type = 'update',
        changed_at  = now()
    WHERE email = NEW.email;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_password_resets_mirror_delete() RETURNS TRIGGER AS $$
BEGIN
    IF EXISTS (SELECT 1 FROM password_resets_mirrors WHERE email = OLD.email) THEN
        UPDATE password_resets_mirrors
        SET token       = OLD.token,
            updated_by  = current_user,
            change_type = 'delete',
            changed_at  = now()
        WHERE email = OLD.email;
    END IF;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_password_resets_mirror_insert ON password_resets;
CREATE TRIGGER trg_password_resets_mirror_insert AFTER INSERT ON password_resets
    FOR EACH ROW EXECUTE FUNCTION fn_password_resets_mirror_insert();
DROP TRIGGER IF EXISTS trg_password_resets_mirror_update ON password_resets;
CREATE TRIGGER trg_password_resets_mirror_update AFTER UPDATE ON password_resets
    FOR EACH ROW EXECUTE FUNCTION fn_password_resets_mirror_update();
DROP TRIGGER IF EXISTS trg_password_resets_mirror_delete ON password_resets;
CREATE TRIGGER trg_password_resets_mirror_delete AFTER DELETE ON password_resets
    FOR EACH ROW EXECUTE FUNCTION fn_password_resets_mirror_delete();

-- ============================================================
-- personal_access_tokens -> personal_access_tokens_mirrors
-- ============================================================

CREATE OR REPLACE FUNCTION fn_personal_access_tokens_mirror_insert() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO personal_access_tokens_mirrors (
        tokenable_id, tokenable_type, name, token, abilities, last_used_at, expires_at,
        updated_by, change_type, changed_at
    ) VALUES (
        NEW.tokenable_id, NEW.tokenable_type, NEW.name, NEW.token, NEW.abilities,
        NEW.last_used_at, NEW.expires_at, current_user, 'insert', now()
    );
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_personal_access_tokens_mirror_update() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO personal_access_tokens_mirrors (
        tokenable_id, tokenable_type, name, token, abilities, last_used_at, expires_at,
        updated_by, change_type, changed_at
    ) VALUES (
        NEW.tokenable_id, NEW.tokenable_type, NEW.name, NEW.token, NEW.abilities,
        NEW.last_used_at, NEW.expires_at, current_user, 'update', now()
    );
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_personal_access_tokens_mirror_delete() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO personal_access_tokens_mirrors (
        tokenable_id, tokenable_type, name, token, abilities, last_used_at, expires_at,
        updated_by, change_type, changed_at
    ) VALUES (
        OLD.tokenable_id, OLD.tokenable_type, OLD.name, OLD.token, OLD.abilities,
        OLD.last_used_at, OLD.expires_at, current_user, 'delete', now()
    );
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_personal_access_tokens_mirror_insert ON personal_access_tokens;
CREATE TRIGGER trg_personal_access_tokens_mirror_insert AFTER INSERT ON personal_access_tokens
    FOR EACH ROW EXECUTE FUNCTION fn_personal_access_tokens_mirror_insert();
DROP TRIGGER IF EXISTS trg_personal_access_tokens_mirror_update ON personal_access_tokens;
CREATE TRIGGER trg_personal_access_tokens_mirror_update AFTER UPDATE ON personal_access_tokens
    FOR EACH ROW EXECUTE FUNCTION fn_personal_access_tokens_mirror_update();
DROP TRIGGER IF EXISTS trg_personal_access_tokens_mirror_delete ON personal_access_tokens;
CREATE TRIGGER trg_personal_access_tokens_mirror_delete AFTER DELETE ON personal_access_tokens
    FOR EACH ROW EXECUTE FUNCTION fn_personal_access_tokens_mirror_delete();

-- ============================================================
-- failed_jobs -> failed_jobs_mirrors
-- ============================================================

CREATE OR REPLACE FUNCTION fn_failed_jobs_mirror_insert() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO failed_jobs_mirrors (uuid, connection, queue, payload, exception, failed_at, updated_by, change_type, changed_at)
    VALUES (NEW.uuid, NEW.connection, NEW.queue, NEW.payload, NEW.exception, NEW.failed_at, current_user, 'insert', now())
    ON CONFLICT (uuid) DO UPDATE
        SET connection  = EXCLUDED.connection,
            queue       = EXCLUDED.queue,
            payload     = EXCLUDED.payload,
            exception   = EXCLUDED.exception,
            updated_by  = current_user,
            change_type = 'insert',
            changed_at  = now();
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_failed_jobs_mirror_update() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO failed_jobs_mirrors (uuid, connection, queue, payload, exception, failed_at, updated_by, change_type, changed_at)
    VALUES (NEW.uuid, NEW.connection, NEW.queue, NEW.payload, NEW.exception, NEW.failed_at, current_user, 'update', now())
    ON CONFLICT (uuid) DO UPDATE
        SET connection  = EXCLUDED.connection,
            queue       = EXCLUDED.queue,
            payload     = EXCLUDED.payload,
            exception   = EXCLUDED.exception,
            updated_by  = current_user,
            change_type = 'update',
            changed_at  = now();
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_failed_jobs_mirror_delete() RETURNS TRIGGER AS $$
BEGIN
    INSERT INTO failed_jobs_mirrors (uuid, connection, queue, payload, exception, failed_at, updated_by, change_type, changed_at)
    VALUES (OLD.uuid, OLD.connection, OLD.queue, OLD.payload, OLD.exception, OLD.failed_at, current_user, 'delete', now())
    ON CONFLICT (uuid) DO UPDATE
        SET updated_by  = current_user,
            change_type = 'delete',
            changed_at  = now();
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trg_failed_jobs_mirror_insert ON failed_jobs;
CREATE TRIGGER trg_failed_jobs_mirror_insert AFTER INSERT ON failed_jobs
    FOR EACH ROW EXECUTE FUNCTION fn_failed_jobs_mirror_insert();
DROP TRIGGER IF EXISTS trg_failed_jobs_mirror_update ON failed_jobs;
CREATE TRIGGER trg_failed_jobs_mirror_update AFTER UPDATE ON failed_jobs
    FOR EACH ROW EXECUTE FUNCTION fn_failed_jobs_mirror_update();
DROP TRIGGER IF EXISTS trg_failed_jobs_mirror_delete ON failed_jobs;
CREATE TRIGGER trg_failed_jobs_mirror_delete AFTER DELETE ON failed_jobs
    FOR EACH ROW EXECUTE FUNCTION fn_failed_jobs_mirror_delete();

-- ============================================================
-- prices <-> products price sync
-- ============================================================

CREATE OR REPLACE FUNCTION fn_sync_product_price_on_type_change() RETURNS TRIGGER AS $$
BEGIN
    IF OLD.type_id IS DISTINCT FROM NEW.type_id THEN
        SELECT price INTO NEW.price FROM prices WHERE type_id = NEW.type_id;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION fn_sync_products_on_price_change() RETURNS TRIGGER AS $$
BEGIN
    UPDATE products SET price = NEW.price WHERE type_id = NEW.type_id;
    RETURN NULL;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS update_product_price_on_type_change ON products;
CREATE TRIGGER update_product_price_on_type_change BEFORE UPDATE ON products
    FOR EACH ROW EXECUTE FUNCTION fn_sync_product_price_on_type_change();
DROP TRIGGER IF EXISTS update_product_price_on_price_change ON prices;
CREATE TRIGGER update_product_price_on_price_change AFTER UPDATE ON prices
    FOR EACH ROW EXECUTE FUNCTION fn_sync_products_on_price_change();

