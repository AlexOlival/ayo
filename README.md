<p align="center">
    <img title="ayo" width="20%" src="https://i.imgur.com/So0rxLO.png" />
</p>

## Overview
Ayo is an easy, snappy and fun reminder app.
It's  meant to be a way for us to sharpen our software crafting, UI and UX skills.
The app is fully open source.

## Maintainers
- Alexandre Olival [@AlexOlival]( https://github.com/AlexOlival )
- Guilherme Almeida [@colgatekoala]( https://github.com/colgatekoala )
- João Cruz [@JoaoFSCruz]( https://github.com/JoaoFSCruz )

## Technologies
The app is built using MySQL 5.7, Laravel 5.8, Vue 2 and Tailwind 0.7.4.

## Getting Started
- Clone the repository to your local machine
- Configure Homestead (check the [Laravel documentation](https://laravel.com/docs/5.7/homestead))
- Check if you can deploy the application locally
- Run `composer install` to install PHP dependencies
- Run `yarn` to install JavaScript dependencies
- Copy .env.example to .env and set your local variables (database, mailtrap, etc.)
- Run `php artisan key:generate`
- Optionally run `yarn dev` to compile the front-end assets.
- That's it!

If you're on a mac, feel free to use [Valet](https://laravel.com/docs/5.7/valet) as it is a slightly easier way to get setup - however it will be on you to
install other dependencies like Redis and MySQL.

## Contributing
(This is a rough outline while we don't have a proper contribution guide)
- Try to keep features separate on their own branch.
- Branch from `develop` and then make a Pull Request back to it.
- Explain your changes in your PR description.
- Add at least one reviewer so we can all discuss and approve (PRs cannot be merged without at least one approval).
- [Follow PSR-2.](https://www.php-fig.org/psr/psr-2/)
- And finally: *WRITE TESTS!* We're aiming for a fairly big coverage. PRs of new features without tests won't be accepted.

## Quality Tooling
If you're on PhpStorm, you should install the Php Inspections (EA Extended) - it's a great static analysis tool.
The PHP_CodeSniffer is great to warn you about PSR-2 violations, and it can integrate with your editor of choice.
Also, the Laravel Framework plugin for PhpStorm can be helpful.

## MVP
Once we have a first working proof of concept, we can merge to `master` and tag a beta release!

## Future Prospects
Open an API and create an Android and iOS mobile client.
Also, we would like to actually deploy this application to production - even if for a little while.

Regardless, the goal is to have fun, learn, improve and us have something to show for :)
