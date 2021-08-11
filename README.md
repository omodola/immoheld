# Immoheld

A lightweight real estate app served with codeigniter development server. Postgres database running on docker. Coding style:  [Clean Architecture](https://github.com/ChrisLeNeve/books/blob/master/Clean%20architecture.pdf)

## Resources
- Php
- Postgres
- Html
- Javascript (JQuery)
- Docker

# Install the Service
Ensure you have installed:
- composer
- docker

# Running the Service
To run the application, ensure at the root of the /app there is a .env file, then:

	cd [app]
	docker-compose up -d
	composer update
	php vendor/bin/phinx migrate
	php spark serve

# useful links
    [/listings/populate]() - create random listings with defined size 11
    [/listings/populate/{:x}]() - create random x number of listings
    [/listings/{:id}}]() - get details of a listing given by the id