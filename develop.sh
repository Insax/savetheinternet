#!/usr/bin/env bash

# Set environment variables for dev
export APP_PORT=${APP_PORT:-80}

# Create docker-compose command to run
COMPOSE="docker-compose"

# If we pass any arguments...
if [ $# -gt 0 ];then

    # If "bash" is used, pass-thru to "bash"
    # inside a new container
    if [ "$1" == "bash" ]; then
        shift 1
        $COMPOSE run --rm \
            app \
            bash -c "$@"

    # If "composer" is used, pass-thru to "composer"
    # inside a new container
    elif [ "$1" == "composer" ]; then
        shift 1
        $COMPOSE run --rm \
            app \
            composer "$@"

    # If "test" is used, run unit tests,
    # pass-thru any extra arguments to php-unit
    elif [ "$1" == "test" ]; then
        shift 1
        $COMPOSE run --rm \
            app \
            ./vendor/bin/phpunit "$@"

    # If "npm" is used, run npm
    # from our node container
    elif [ "$1" == "npm" ]; then
        shift 1
        $COMPOSE run --rm \
            node \
            npm "$@"

    # If "npm" is used, run npm
    # from our node container
    elif [ "$1" == "npx" ]; then
        shift 1
        $COMPOSE run --rm \
            node \
            npx "$@"

    # If "yarn" is used, run npm
    # from our node container
    elif [ "$1" == "yarn" ]; then
        shift 1
        $COMPOSE run --rm \
            node \
            yarn "$@"

    # Else, pass-thru args to docker-compose
    else
        $COMPOSE "$@"
    fi

else
    $COMPOSE ps
fi