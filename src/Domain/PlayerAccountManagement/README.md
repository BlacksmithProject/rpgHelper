# Player Account Management

This part is about registration and login.

You can use the `\App\Domain\PlayerAccountManagement\PlayerCommandBus`
to execute two commands:

- `\App\Domain\PlayerAccountManagement\Command\PlayerRegistration\RegisterPlayer`
- `\App\Domain\PlayerAccountManagement\Command\PlayerRegistration\RegisterAuthenticationToken`

You might not want to have a token, but if you would, you need to 
execute those commands in that order, remember to rollback if the second
fails.