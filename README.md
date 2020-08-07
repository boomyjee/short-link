<p align="center">
    <img alt="Short Link" title="Short Link" src="/public/img/short-link.jpg">
</p>

<p align="center">
    <img alt="license" src="https://img.shields.io/badge/license-MIT-blue.svg">
    <img alt="php" src="https://img.shields.io/badge/php-%3E%3D5.3.9-blue">
    <img alt="awesome" src="https://camo.githubusercontent.com/fef0a78bf2b1b477ba227914e3eff273d9b9713d/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f617765736f6d652533462d796573212d627269676874677265656e2e737667">
    <img alt="languages" src="https://img.shields.io/badge/slim-4.0-blue">
</p>

<p align="center">
    Simple URL shortener written in PHP using the Slim framework.
</p>

## Features
- creation of short URLs
- click-tracking the short URLs

## Install
- clone or download the code
- run `composer install` from the project root directory 
- copy file `.env.sample` into `.env`
- fill `.env` file with own data
- you must have created MySQL database
- run `php ./bin/app.php migrations:migrate` in console

Have fun!

### License

Application is [MIT licensed](./LICENSE).
