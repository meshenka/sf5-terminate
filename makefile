.PHONY: cs, help, start, stop, cc, stan, test

PHP = php 
SYMFONY = symfony
COMPOSER = composer
CONSOLE = $(PHP) bin/console 

##
## Local
## -------
##

start: ## Start local server
	$(SYMFONY) server:start --no-tls

stop: ## Stop local server
	$(SYMFONY) server:stop 

cc: vendor
	$(CONSOLE) cache:clear	 

##
## Quality
## -------
##

cs: ## Apply coding standard
cs: vendor
	vendor/bin/php-cs-fixer fix

stan: ## phpstan analysis
stan: vendor
	vendor/bin/phpstan analyse --no-progress --memory-limit=2G -n -l 7 src/

test: ## run all tests
test: cc cs stan

##
## Build
## -------
##

.env: ##configure symfony app
.env: .env.dist
	@if [ -f .env ]; \
	then\
		echo '\033[1;41m/!\ The .env.dist file has changed. Please check your .env file (this message will not be displayed again).\033[0m';\
		touch .env;\
		exit 1;\
	else\
		echo cp .env.dist .env;\
		cp .env.dist .env;\
	fi

composer.lock: composer.json
	$(COMPOSER) update --lock --no-scripts --no-interaction

vendor: ## Install symfony dependencies
vendor: composer.lock
	$(COMPOSER) install


.DEFAULT_GOAL := help
help: ## Makefile help
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'