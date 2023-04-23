-- create the databases
CREATE DATABASE IF NOT EXISTS database;

-- -- Execute Doctrine migrations
-- php bin/console doctrine:migrations:diff
-- php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration