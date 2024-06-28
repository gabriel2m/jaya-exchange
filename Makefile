SAIL="./vendor/bin/sail"

install:
	docker run --rm --interactive --tty --volume .:/app --user $(shell id -u):$(shell id -g) composer install
	cp .env.example .env
	$(SAIL) up -d
	$(SAIL) npm install
	$(SAIL) artisan key:generate
	$(SAIL) artisan migrate