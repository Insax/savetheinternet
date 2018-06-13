# SaveTheInternet

<p align="center">
<img height="150" width="auto" src="https://i.imgur.com/SXC70FD.png" /><br>
Save the Internet with us
</p>

<hr>

## :pushpin: About 

On 20 June, the European Parliament will vote on the Copyright Directive. <br>
Members of the parliament are the only ones that can stand in the way of bad copyright legislation.

<hr>

## :computer: Website 

[https://savetheinternet.info](https://savetheinternet.info)

<hr>


## Development

**Requirements**
- Docker [https://docs.docker.com/install/](https://docs.docker.com/install/)
- Docker-Compose [https://docs.docker.com/compose/install/](https://docs.docker.com/compose/install/)

**Getting started**

- Install the requrirements listed above
- Start the docker daemon (follow the instructions provided for your OS)
- Navigate to the project root within your shell (PowerShell/Bash)
- run `docker-compose up -d app` to start the development server
    - It will take some time at the first start, subsequent starts are much faster
- run `docker-compose run --rm app composer install` to install dependencies
- open [http://localhost:8080](http://localhost:8080) to view the site

<hr>

## :wrench: Used technologies / Libraries / Frameworks

- [PHP 7.1.12-1](http://www.php.net/)
- [Twig](https://twig.symfony.com/)
- [Bootstrap 4.1.1 (JS & CSS)](https://getbootstrap.com/)
- [JQuery 3.3.1](https://jquery.com/)
- [PopperJS 1.14.3](https://popper.js.org/)

<hr>

