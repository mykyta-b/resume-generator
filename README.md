# README #

Application, which generates a github resumé for a given
github account

### Mini-FAQ:
- Github-Rate-Limit: Your app should not hit any public rate limit. If your app hits rate limits,
use your github username+password to get up to 5000 req/hour.

## Notes
- During the repo percentage calculation script does not take in account repositories
where language was not specified.

## Installation
- `composer install`
- `npm install`
- `npm run build`
- `cp .env.prod.example .env`
- `/usr/bin/php -S localhost:8000 -t /path/to/resume-generator/public /path/to/resume-generator/public/index.php`
- Run in your browser`localhost:8000`
