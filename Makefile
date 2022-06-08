.DEFAULT_GOAL: help
.PHONY: help dep-dev lint test docker push

SHELL          := /bin/bash
DOCKER_IMAGE   := ometriadev/ometria.nginx-php-fpm
DOCKER_TAG     ?= "$$(git rev-parse --short HEAD)"
DOCKER_BUILDKIT := 1
XDEBUG_ENABLED := "true"

help: ## Displays this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

lint: ## Lint repo
	@echo "Would lint"

test: ## Run tests
	@echo "Would test"

buster: ## Build the docker image
	docker build \
		--build-arg XDEBUG_ENABLED="false"\
		--platform arm64\
		-f Dockerfile\
		-t $(DOCKER_IMAGE) \
		.

alpine: ## Build the docker image
	docker build \
		--build-arg XDEBUG_ENABLED="false"\
		--platform arm64\
		-f Dockerfile.alpine\
		-t $(DOCKER_IMAGE) \
		.

run:
	docker run -p 80:80 ometriadev/ometria.nginx-php-fpm

push: ## Push the docker image
	docker push $(DOCKER_IMAGE):$(DOCKER_TAG)