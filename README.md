# Doctrine-Migration-independent-from-your-app

##Introduction
This is an simple doctrine migaration integration to your app that use doctrine to handle database operations. 
When you deploy your app and when you release another version with new database functionalities and change of existing functinalities
you can use doctrine migration classes (Normal PHP classes used to make database changes) to make those changes smooth.

Whatever the framework you use ZF2, Symfony or none doesn't matter. This runs idependently and not bind with your app.

##Step 1: Install Doctrine-migration to your app

```
   composer require doctrine/doctrine-migrations-bundle
   composer require doctrine/orm
````

##Step 2: Create cli-config.php

Why cli-config.php?. the name matters, because when you run doctrine-migration commands first it search for cli-config.php.
So we are using that file to tell doctrine that what should happen when we are runing doctrine commands.

All the codes with comments are available at the repository ./Migration folder

### Step 3: Create configuration.yml

````
name: Doctrine Sandbox Migrations
migrations_namespace: DoctrineMigrations
table_name: doctrine_migration_versions
migrations_directory: ../../docker/migration_class
````
1.table_name

This is the name of the table that is going to create on your database. This is used to hold migration informations.

2.migrations_directory

This is the folder that doctrine used to create doctrine migration classes.

## Commands

Before you run your commands copy and paste cli-config.php file to vender/bin folder

### Create first doctrine class
````    
./doctrine-migrations migrations:diff --configuration ../../Doctrine-Migration/configuration.yml
````
This will create your first doctrine migration class by making diff with your original database and your doctrine database
configurations. When you change doctrine configuration run this command.


### Applying changes to database

Once you create the migration class
````
./doctrine-migrations migrations:migrate --configuration ../../config/migration/configuration.yml
```

This will excute sql statements 

### To see sql statements that is going to be executed

````
./doctrine-migrations migrations:migrate --dry-run --configuration ../../config/migration/configuration.yml
```












