# Blue Apron Weekly
Weekly recipes sent out by blue apron

## Included Packages
* PHP 7.0.4

## Docker Setup

### Build Image
```
#!bash

docker build -t blue-apron-weekly .
```

#### Deploy
```
#!bash

docker run -d --name blue-apron-weekly -p 80:80 -p 443:443 blue-apron-weekly
```