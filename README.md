# Componentum
A component based very simple php framework environment

---
## Plugins
Componentum  has plugins such as Authentication, Blog, Category, Page etc and those plugins contains a Main.php. Main file has necessary endpoints for the module. There are also some folders inside.

* Langs folder is for the language translations. It should contain language shortnames first letter uppercased. For example, English -> En, Turkish -> Tr. In that language folders, the related module name should be given as a name and then inside necessary text should be given as an associative array.
Example code: 
```php
// plugins/Auth/Langs/En/User.php
return [
    'title' => 'Title'
];
// plugins/Auth/Langs/Tr/User.php
return [
    'title' => 'Başlık'  
];
```

* Models folder has files which are written in php files as arrays. They show the schema of the module. Every plugin can have numerous models. Model title translations can be called from langs files by using @<filename>/<nickname>. Componentum will provide the text for the preferred client language automatically. For example: 'title' => '@user/username'


*Filters folder has files which are used as middlewares. They can be used in maps.

---
## Maps
Maps are the base parts of Componentum. A simple map file should have an is key in order to define its identity. These identities are the plugins. If any plugin needs parameters, it is provided via use key.

Code example: 

```php
// maps/Home.php

return [
    'is' => 'Home',
    'use' => [
        'homepage' => 'Home'
    ]
];

```
homepage is a parameter which will be used in Home plugin. If we did not code the plugin, we will be provided by the author about the parameters. Here, homepage defines which template will be the index page.

# TODO
- [ ] Wiki will be provided
- [ ] Module and code samples will be added
- [ ] Tests will be provided
- [ ] Built-in packages will be transfered to composer
- [ ] A package manager might be useful for the plugins
