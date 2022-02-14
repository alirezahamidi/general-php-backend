# General PHP Backend

A General PHP BackEnd That Uses For All Projects Of My Website.

That Project Have Authorization on Itself And Some General Things Like User Management.

Please consider this project specified to my projects but with some changes you can use it for your projects.

Base system consist of three parts,
    |_ Modules
    |_ Resource
    |_ Helpers

You can add a module as Needed and the requests will find it in directory as it named.
In default mode we restricted modules without specified Access.
to open the module for requests you should add its Access Level in app/resource/config.php.

# Dont Forget to Add Your DB Info to env.php

and you can add name of your dbs to config file to access it in global config Variable,
Also you can use mysql helper (app/helpers/db/mysql) to generate simple sql queries.