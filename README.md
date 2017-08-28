# deploypress

Automated WordPress atomic deployment with [composer](https://getcomposer.org/), [deployer](https://deployer.org/) and [wp-cli](https://wp-cli.org/).

You should already have these installed globally.

## Getting started
```
$ git clone git@github.com:andreiio/deploypress.git
$ cd deploypress
$ composer install
```

If you plan to develop on a local environment, you should also run the following command, to create the required shared folders and symlinks.
```
$ dep local:shared
```

To view all the existing deployment commands and their descriptions, use:
```
$ dep list
```

More on deployer in the [official docs](https://deployer.org/docs).

## Deployment configuration
All the deployment-related settings are stored in `config/deploy/hosts.yml`. Use [`config/deploy/hosts.example.yml`](config/deploy/hosts.example.yml) as a starting point.

## WordPress configuration
All the configuration values for WordPress are stored in the root `.env` file. Use [`.env.example`](.env.example) as a starting point. On a deployed system, you should create a new `.env` file and upload it to the `${deploy_path}/shared/` dir.

This doesn't ship with with themes or plugins, just the file structure you need to get started. Add new themes and plugins through [wpackagist.org](https://wpackagist.org/).

## Cross-stage content sync
Using the included deployer tasks, you can do a one-way database sync between `production` and `staging`:
```
$ dep db:pull production
$ dep db:push staging
```

Same thing, but for the files in `public/content/uploads`:
```
$ dep files:pull production
$ dep files:push staging
```

_Please note that, by design, the pull methods only work on `production`, while the push methods work on any non-`production` stage. You \*really\* shouldn't upload staging content to production._
