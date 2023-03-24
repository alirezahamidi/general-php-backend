# General PHP Backend

An Generalized backend application to cover simple needs for start a website quickly.

This framework based on a simple user Management system, Access Control and simple Modular tree to cover new Modules and New actions needs.
In start place we will get a post request from client to root index.php.
This request most include request and action in header.
Based on request parameter project will search for module. ( the request parameter is the module name )
In modules "call_functions" function will call and in switch we will choose the fuction that will answer to our action.
And after all in function you can respond to your request with echo.

Base system consist of three parts,
    |_ Modules
    |_ Resource
    |_ Helpers

In default mode we restricted modules without specified Access.
To open the module for requests you should add its Access Level in app/resource/config.php.

# Dont Forget to Add Your DB Info to env.php

And you can add name of your dbs to config file to access it in global config Variable,
Also you can use mysql helper (app/helpers/db/mysql) to generate simple sql queries.