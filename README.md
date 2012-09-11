# PostmanBundle [![Build Status](https://secure.travis-ci.org/alexeyshockov/PostmanBundle.png)](http://travis-ci.org/alexeyshockov/PostmanBundle)

## Goal

Foundation for mail handling (like Symfony's core HttpFoundation for HTTP).

## Installation

## Usage

Define pipelining mail from your MTA to Symfony's console command. In Exim 4 this may be done by router

```
# /etc/exim4/conf.d/router/postman
postman:
    debug_print = "R: postman for $local_part@$domain"
    driver      = accept
    transport   = postman_pipe
```

and transport

```
# /etc/exim4/conf.d/transport/postman
postman_pipe:
    debug_print = "T: postman_pipe for $local_part@$domain"
    driver      = pipe

    return_fail_output
    # Failure to exec is treated specially, and causes the message to be frozen.
    freeze_exec_fail

    path    = "/bin:/usr/bin:/usr/local/bin"
    command = "/usr/bin/php /var/www/app/app/console -e=prod postman:mail:handle"
    user    = www-data
    group   = www-data
    umask   = 022
```
