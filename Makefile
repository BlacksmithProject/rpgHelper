dev-from-scratch:
	vagrant destroy -f && vagrant up

install: composer remove-useless-files database

composer:
	-rm -rf ./vendor
	-a | composer install

database:
	-bin/console d:d:d --force
	bin/console d:d:c
	-y | bin/console doctrine:migrations:migrate

remove-useless-files:
	rm -rf ./config/routes
	rm -rf ./src/Controller
	rm -rf ./src/Entity
	rm -rf ./src/Migrations
	rm -rf ./src/Repository

pretty:
	./vendor/bin/pretty

pretty-fix:
	./vendor/bin/pretty fix

stan:
	./vendor/bin/phpstan analyse -l 7 src

test:
	./bin/phpunit

test-CI:
	./bin/phpunit --coverage-clover=coverage.clover

CI: stan test-CI

release:
	git add CHANGELOG.md && git commit -m "release(v$(VERSION))" && git tag v$(VERSION) && git push && git push --tags

start:
	bin/console server:start

stop:
	bin/console server:stop

diff:
	bin/console doctrine:migrations:diff

.PHONY: dev-from-scratch composer pretty pretty-fix stan test test-CI CI release start stop