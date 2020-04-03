# Dailymotion test

## How to run the code?

This project contains a docker-compose.yml with everything needed to run the code:

* a PHP 7.4 container
* a nginx container to make all the routes point to public/index.php
* a mysql container which has its schema created on start.

To **run the code**, open a console and run this in the project root.
```bash
docker-compose up -d --build
```

Then, the API will be available on **127.0.0.1** (I didn't clean the default nginx conf, so localhost won't be available).

You can find a postman collection with a kind of scenario in the `postman` directory.

## What's in the code?

### public/index.php

This file is the entry point for nginx. It initializes the container and the router.

It creates the Request object, gives it to the router, and wait for the Response instance.

Then it sends the headers and the body. 

### src
In this directory we found three other ones. I decided to use some ddd patterns I used to: CQS, hexagonal architecture.

It may sometimes be overkill for this test, but in reality is very useful.

#### - src/Application & src/Domain
These directories contain code completely agnostic of any kind of framework or infrastrucutre details. 
I mean I could take all that code and put it in a symfony|zend|whatever framework without touch one line of code.

It represents all the "domain" rules and object, and all the user's intention, and how to handle its.

All that code does not know that it is used by HTTP and does not know that the data is stored in MySQL.

When we open the `Domain` directory, we see all the objects the code is able to manipulate.  
When we open the `Application` directory, we see how the code handles Domain objects.

#### - src/Infrastructure

Here we can find all the code that handle infrastructure details as HTTP controllers, Mysql repositories which implements the domain interfaces.

## Routes documentation

### Create a video
```
curl -X POST '127.0.0.1/videos' --header 'Content-Type: application/json' \
-d '{
	"title": "franklin",
	"thumbnail": "https://franklin"
}'
```

Will return the resource created:
```json
{
    "data": {
        "id": 1,
        "title": "franklin",
        "thumbnail": "https://franklin"
    }
}
```

### Create a playlist
```
curl -X POST '127.0.0.1/playlists'--header 'Content-Type: application/json' \
-d '{
	"name": "cartoon"
}'
```

Will return the resource created:
```json
{
    "data": {
        "id": 1,
        "name": "cartoon"
    }
}
```

### Update a playlist
```
curl -X PATCH '127.0.0.1/playlists/1' --header 'Content-Type: application/json' \
-d'{
	"name": "cartooooon"
}'
```

Will return the playlist updated:
```json
{
    "data": {
        "id": 1,
        "name": "cartooooon"
    }
}
```

### Get all videos
```
curl -X GET '127.0.0.1/videos'
```

Will return a list of videos:
```json
{
    "data": [
        {
            "id": 1,
            "title": "franklin",
            "thumbnail": "https://franklin"
        }
    ]
}
```

### Get all playlists
```
curl -X GET '127.0.0.1/playlists'
```

Will return a list of playlists:
```json
{
    "data": [
        {
            "id": 1,
            "name": "cartoon"
        }
    ]
}
```

### Link a video to a given playlist
```
curl -X PUT '127.0.0.1/playlists/1/videos/1'
```

This route will add the video at the last position into the playlist.

### Get all videos for a given playlists
```
curl -X GET '127.0.0.1/playlists/1/videos'
```

Will return a list of videos ordered by position:
```json
{
    "data": [
        {
            "id": 1,
            "title": "franklin",
            "thumbnail": "https://franklin"
        }
    ]
}
```

### Unlink a video from a playlist
```
curl -X DELETE '127.0.0.1/playlists/1/videos/1'
```

### Delete a playlist
```
curl -X DELETE '127.0.0.1/playlists/1'
```

### Delete a video
```
curl -X DELETE '127.0.0.1/videos/1'
```


##################################################################

## Reminder of the exercice
Dailymotion is building a new feature "The playlist"

The feature is simple : The user can create a list of ordered videos.

As a core api developer, you are responsible for building this feature and expose it through API.
### Task
The task is to create an api that manages an ordered playlist.
An example of a minimal video model : (You might add extra fields to do this project)
```
video {
id : the id of the video,
title: the title of the video
thumbnail : The url of the video
...
}
```

An example of a minimal playlist model : (You might add extra fields to do this project)
```
playlist {
id : The id of the playlist,
name : The name of the playlist
......
}
```
The API must support the following use cases:
* **Return the list of all videos**
```
{
"data" : [
{
"id": 1,
"title": "video 1"
....
},
{
"id": 2,
"title": "video 2"
}
....
]
}
```
* **Return the list of all playlists**
```
{
"data" : [
{
"id": 1,
"name": "playlist 1"
....
},
{
"id": 2,
"name": "playlist 2"
}
....
]
}
```
* **Create a playlist**
* **Show informations about the playlist**
```
{
"data" : {
"id": 1,
"name": "playlist 1"
}
}
```
* **Update informations about the playlist**
* **Delete the playlist**
* **Add a video in a playlist**
* **Delete a video from a playlist**
* **Return the list of all videos from a playlist (ordered by position)**
```
{
"data" : [
{
"id": 1,
"title": "video 1 from playlist 2"
....
},
{
"id": 2,
"title": "video 2 from playlist 2"
}
....
]
}
```

Design and build this API.

### Important notes :
- Removing videos should re-arrange the order of your playlist and the storage.
- PHP or Python languages are supported
- Using frameworks is forbidden, your code should use native language libraries, except for Python, you could use bottlepy
- Use Mysql for storing your data
- Your application has to run within a docker container
- You should provide us the source code (or a link to GitHub) and the instructions to run your code
