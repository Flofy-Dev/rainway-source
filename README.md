# Rainway
> The source of Rainway, an open source old Roblox Revival!
[![Build Status][travis-image]][travis-url]

![](header.png)
<img>https://cdn.discordapp.com/attachments/880094486175289424/1002999219868676116/download.png<img>

Rainway is a project meant to give people the possibility to play legacy versions of the game Roblox, allowing you to deploy servers of your own on a secure code foundation.

## Dependencies
* PHP
* Composer
* Laravel
* Node.js and the NPM package manager

## Installation

```sh
git clone https://github.com/Flofy-Dev/rainway-source
```

Create a .env file with your details (app name, url, database details etc.). The ".env.example" file is an example of the enviroment structure.
Then, run these commands to compile the code and add the database tables.

```sh
composer update
npm install && npm update
npm run prod
php artisan migrate
```

You have now succesfully compiled the Rainway code!

## Usage
If you want to directly deploy the server with Laravel, you can use ```php artisan serve```. <br>
Alternatively, you can use any webserver you want! (Apache, Nginx etc.). <br>
You can use any database driver you want, just configure it in the .env file. For example, the Rainway source should work with MySQL, SQLite, PostgreSQL and more. <br>
Check out the Laravel 8 documentation for more info. https://laravel.com/docs/8.x/

## Release History

* 1.3.0
    * Added the forum.
    
* 1.2.0
    * Added the admin panel.

* 1.1.0
    * Added the launcher, client, users page and public test game.
  
* 1.0.0
    * Working login system

## Meta

Flofy – [Youtube](https://www.youtube.com/channel/UCbkjKnxMaS9PKfGdw4lTJoA) <br>
      - Discord: Flofy#3208 <br>

[My GitHub profile](https://github.com/Flofy-Dev/) <br>

Distributed under the MIT license. See ``LICENSE`` for more information.

## Contributing

1. Fork it (<https:/https://github.com/Flofy-Dev/rainway-source/fork>)
2. Create your feature branch (`git checkout -b feature/fooBar`)
3. Commit your changes (`git commit -am 'Add some fooBar'`)
4. Push to the branch (`git push origin feature/fooBar`)
5. Create a new Pull Request

## More info
You can join the official Discord here! https://discord.com/invite/B7KsMcEY4A <br>
The website of Rainway is https://rainway.xyz. You can check it out there!

<!-- Markdown link & img dfn's -->
[npm-image]: https://img.shields.io/npm/v/datadog-metrics.svg?style=flat-square
[npm-url]: https://npmjs.org/package/datadog-metrics
[npm-downloads]: https://img.shields.io/npm/dm/datadog-metrics.svg?style=flat-square
[travis-image]: https://img.shields.io/travis/dbader/node-datadog-metrics/master.svg?style=flat-square
[travis-url]: https://travis-ci.org/dbader/node-datadog-metrics
[wiki]: https://github.com/yourname/yourproject/wiki
