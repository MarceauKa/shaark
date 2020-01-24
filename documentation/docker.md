# Shaark - Docker

Docker can be used to deploy Shaark. By default it will install Shaark in production mode.  
This behaviour can be changed by editing the Dockerfile.  

## Installation

### Requirements

**NOTE** : You may (probably) need to customize the dockerfile (e.g. changing the network the container is attached at) to suit your case.  

### Quick Run

You can try the application in minutes by running those commands:

```
git clone https://github.com/MarceauKa/shaark
cd shaark
docker-compose up -d .
```

And then running a reverse proxy like NGINX on the `nginx_net`.  
If you don't already have a reverse proxy, you can google on how to create one.
