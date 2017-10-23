# TweetMap Web user interface

## Getting Started

#### App Installations for Mac OS (for Windows get bitnami WAMP)
bitnami-mappstack-7.0.23-0-osx-x86_64-installer.dmg

#### Dependancies

- Apache - 2.4.18
- Bitnami MAPP Stack 7.0.23-0

## Procedure

Download the Bitnami MAPP Stack 7.0.23-0 mappstack image and Application at the Document Root 
- $ cd /Users/Fiona/Desktop/WebApp

During installation, set
- Set Apache Web Server Port - 8888
- Set SSL Port - 8445
- Set Databse Server Port - 5434

Set PostgreSQL credentials
- username- postgres
- password- test

Open the Bitnami Application 
- Traverse to 'manager osx' within the App folder
- $ cd /Users/Fiona/Desktop/WebApp/App
- Make sure the Apache Web Server is running

#### Cloning the Repository to this location-

- $ cd /Users/Fiona/Desktop/WebApp/App/apache2/htdocs/
- $ git clone https://github.com/fionasequeira/TweetMap.git

#### Setting up 

- Open a browser and enter - http://localhost:8888/TweetMap/app
